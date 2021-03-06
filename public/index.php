<?php
require "../bootstrap.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

$routeList = [
    'home' => '\Src\Controllers\HomeController#index#GET',
    'uploadCsv' => '\Src\Controllers\UploadController#index#POST',
    'stocks' => '\Src\Controllers\StocksController#index#GET',
    'stock-list' => '\Src\Controllers\StocksController#stocksByName#POST',
    'stock-forecast' => '\Src\Controllers\StocksController#stockForecast#POST',
    'stock-buy-info' => '\Src\Controllers\StocksController#viewSelectedBuyStock#POST',
    'stock-sell-info' => '\Src\Controllers\StocksController#viewSelectedSellStock#POST',
    'make-transaction' => '\Src\Controllers\TransactionsController#transaction#POST',
    'my-orders' => '\Src\Controllers\TransactionsController#index#GET|POST',
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
$methods = explode('|', $method);
if(!in_array($requestMethod, $methods)) {
    halt();
}

if (is_callable(array($className, $action))) {
    $controller = new $className();
    $controller->$action();
} else {
    halt();
}
