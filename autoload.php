<?php

function autoload_namespace($className)
{
    require_once str_replace('\\', '/', __DIR__) . '/' . str_replace('\\', '/', $className) . '.php';
}