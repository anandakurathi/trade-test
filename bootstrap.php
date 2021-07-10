<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = new DotEnv(__DIR__);
$dotenv->load();

error_reporting(
    (getenv('APP_ENV') === 'dev') ? -1 : 0
);

const DS = DIRECTORY_SEPARATOR;
const PATH = __DIR__ . DS.'src'.DS;
const EXTENSION = '.php';
const APP = PATH.'src'. DS;

// set the time zone
date_default_timezone_set('Asia/Kolkata');
session_start();

function matchRoute($route, $routeList)
{
    return (array_key_exists($route, $routeList)) ? $routeList[$route] : null;
}

function halt()
{
    $controller = new \Src\Controllers\BaseController();
    $controller->pageNotFound();
    exit();
}
