<?php


namespace core;


class Response
{
    public static function json($data = [],$code = 200)
    {
        http_response_code($code);
        header("Content-Type: application/json;charset=utf-8");
        echo json_encode($data);
    }

    public static function error($code, $message)
    {
        http_response_code($code);
        exit($message);
    }
}
