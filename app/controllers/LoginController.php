<?php


namespace app\controllers;


use app\models\User;
use core\Auth;
use core\Controller;
use core\View;

class LoginController extends Controller
{
    public function index()
    {
        return View::display('login');
    }

    public function login()
    {
        $error = $this->loginValidation();

        if (!empty($error)){
            return View::display('login', compact('error'));
        }

        $user = new User();
        $user = $user->where('login', '=', $_POST['login'])
            ->where('password', '=', $_POST['password'])
            ->count();
        if ($user == 0){
            return View::display('login', ['error' => 'неправильные реквизиты доступа']);
        }

        Auth::auth();
        redirect('/');
    }

    private function loginValidation()
    {
        $error = '';
        if (empty(trim($_POST['login'])) || empty(trim($_POST['password']))){
            $error = 'введенные данные не верные';
        }
        return  $error;
    }

    public function logout()
    {
        Auth::logout();
        redirect('/');
    }

}
