<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array $handler): void
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_]+)', $path);
        
        $this->routes[] = [
            'method'  => strtoupper($method),
            'pattern' => "#^" . $pattern . "$#",
            'handler' => $handler
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = str_replace('/sisgovernanca/public', '', $path);
        
        if (empty($path)) {
            $path = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && preg_match($route['pattern'], $path, $matches)) {
                [$controllerClass, $action] = $route['handler'];

                if (!class_exists($controllerClass)) {
                    http_response_code(500);
                    echo "Erro: Controller [{$controllerClass}] não encontrada.";
                    return;
                }

                $controller = new $controllerClass();

                // CORREÇÃO AQUI: Trocado method_callable por is_callable
                if (!is_callable([$controller, $action]) && !method_exists($controller, $action)) {
                    http_response_code(500);
                    echo "Erro: Método [{$action}] não existe na Controller [{$controllerClass}].";
                    return;
                }

                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                call_user_func_array([$controller, $action], $params);
                return;
            }
        }

        http_response_code(404);
        echo "<h1>404 - Página Não Encontrada</h1>";
    }
}
?>