<?php
require_once dirname(dirname(__FILE__)) . '/config/config.php';

$controller = $_GET['c'] ?? 'Home';
$method = $_GET['m'] ?? 'index';

$controllerClass = 'App\\Controllers\\' . ucfirst($controller) . 'Controller';
$controllerFile = BASE_PATH . '/app/Controllers/' . ucfirst($controller) . 'Controller.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    die('Controller not found: ' . $controller);
}

require_once $controllerFile;

if (!class_exists($controllerClass)) {
    http_response_code(404);
    die('Controller class not found: ' . $controllerClass);
}

$controllerObj = new $controllerClass();

if (!method_exists($controllerObj, $method)) {
    http_response_code(404);
    die('Method not found: ' . $method);
}

$controllerObj->$method();
