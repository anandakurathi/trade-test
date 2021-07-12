<?php
require "../bootstrap.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

$routeList = [
    'home' => '\Src\Controllers\HomeController#index#GET',
    'uploadCsv' => '\Src\Controllers\UploadController#index#POST',
    'stocks' => '\Src\Controllers\StocksController#index#GET',
    'stock-list' => '\Src\Controllers\StocksController#getStocksByName#POST',
];

$requestUri = trim($_SERVER['REQUEST_URI'], '/');
if (!$requestUri) {
    $requestUri = 'home';
}

$route = matchRoute($requestUri, $routeList);
if (!$route) {
    halt();
}

list($className, $action, $method) = explode('#', $route);
if (strtoupper($method) !== $requestMethod) {
    halt();
}

if (is_callable(array($className, $action))) {
    $controller = new $className();
    $controller->$action();
} else {
    halt();
}
