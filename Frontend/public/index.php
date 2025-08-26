<?php
require __DIR__ . '/../vendor/autoload.php';

use Jenssegers\Blade\Blade;

$blade = new Blade(__DIR__ . '/../views', __DIR__ . '/../cache');

// Load routes
$routes = require __DIR__ . '/../routes.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (array_key_exists($request, $routes)) {
    echo $blade->render($routes[$request]);
} else {
    http_response_code(404);
    echo "404 | Page Not Found";
}
