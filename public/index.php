<?php

// Define a raiz do projeto
define('ROOT_PATH', dirname(__DIR__));

// --- TRATAMENTO DE ARQUIVOS ESTÁTICOS (CSS, JS, IMAGENS) ---
// Se o recurso solicitado for um arquivo físico existente dentro da pasta 'public', serve diretamente.
$publicDir = __DIR__; // Como este index.php está dentro da pasta 'public'
$requestedFile = $publicDir . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (is_file($requestedFile)) {
    return false; // Instrução nativa do PHP para entregar o arquivo estático
}

// Autoload nativo das classes
spl_autoload_register(function ($class) {
    $prefixMap = [
        'App\\'    => ROOT_PATH . '/app/',
        'Core\\'   => ROOT_PATH . '/core/',
        'Config\\' => ROOT_PATH . '/config/',
    ];

    foreach ($prefixMap as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

use Core\Router;

// Instancia o roteador e carrega as rotas
$router = new Router();
require_once ROOT_PATH . '/routes/web.php';

// Dispara a requisição
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
?>