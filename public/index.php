<?php
session_start();
include '../config.php';
include '../core/functions.php';
use core\Router;
spl_autoload_register(function ($class){
    $path = str_replace('\\', '/',$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$class.'.php');
    if (file_exists($path)){
        require $path;
    }
});


Router::get('/', ['controller' => 'Task', 'action' => 'index']);
Router::post('/store', ['controller' => 'Task', 'action' => 'store']);
Router::get('/task(/:id)', ['controller' => 'Task', 'action' => 'edit']);
Router::post('/task/update(/:id)', ['controller' => 'Task', 'action' => 'update']);

Router::get('/login', ['controller' => 'Login', 'action' => 'index']);
Router::post('/login', ['controller' => 'Login', 'action' => 'login']);
Router::post('/logout', ['controller' => 'Login', 'action' => 'logout']);


Router::run();
