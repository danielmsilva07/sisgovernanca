<?php

namespace Core;

class View
{
    public static function render(string $viewPath, array $data = [], string $layout = 'app'): void
    {
        extract($data);

        // Troca pontos e barras para o separador correto do sistema (Windows usa DIRECTORY_SEPARATOR)
        $relativePath = str_replace(['.', '/', '\\'], DIRECTORY_SEPARATOR, $viewPath);
        $viewFile = ROOT_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $relativePath . '.php';

        if (!file_exists($viewFile)) {
            die("Erro: View [{$viewPath}] não encontrada no caminho: {$viewFile}");
        }

        ob_start();
        require_once $viewFile;
        $content = ob_get_clean();

        if ($layout) {
            $layoutFile = ROOT_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . "{$layout}.php";
            if (file_exists($layoutFile)) {
                require_once $layoutFile;
                return;
            }
        }

        echo $content;
    }
}
?>