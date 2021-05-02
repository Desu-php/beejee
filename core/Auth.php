<?php


namespace core;


class Auth
{
    public static function auth()
    {
        $_SESSION['auth'] = true;
    }

    public static function check()
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth']){
            return true;
        }
        return false;
    }

    public static function logout()
    {
        unset($_SESSION['auth']);
    }
}
