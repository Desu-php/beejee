<?php
function getUrl()
{
    $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
    $url = $http .'://'.$_SERVER['HTTP_HOST'];
    return $url;
}

function redirect($url)
{
    header("Location: $url");
}

function debug($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}
