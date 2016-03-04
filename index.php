<?php
error_reporting(E_ALL);
require_once 'autoload.php';
spl_autoload_register('autoload_namespace');
use Request\Request;

$request = new Request();

$controller_name = 'Controllers\\' . ucfirst($request->url_elements[1]) . 'Controller';

if (class_exists($controller_name)) {
    $controller = new $controller_name();
    $action_name = strtolower($request->verb) . 'Action';
    $callback = [$controller_name, $action_name];
    $result = call_user_func($callback, $request);
}

$view_name = 'Views\\' . ucfirst($request->format) . 'View';

if(class_exists($view_name)) {
    $view = new $view_name();
    $view->render($result);
}

//TODO: catch error when invalid url given