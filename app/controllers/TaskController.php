<?php

namespace app\controllers;


use app\models\Task;
use core\Auth;
use core\Controller;
use core\Paginator;
use core\Response;
use core\View;

class TaskController extends Controller
{
    public function index()
    {
        $limit = 3;
        $orderBy = $_GET['orderby'];
        $orderType = $_GET['ordertype'];

        $page = (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) ? $_GET['page'] : 1;

        $offset = ($page - 1) * $limit;

        $countData = new Task();
        $count = $countData->count();

        $lastPage = ceil($count / $limit);

        $task = new Task();

        $tasks = $task->select('id,name,email,status,edited,text')
            ->offset($offset)
            ->limit($limit);

        if (!empty($orderBy) && !empty($orderType)) {
            if ($orderType == 'ASC' || $orderType == 'DESC') {
                $columns = ['name', 'status', 'email'];
                if (in_array($orderBy, $columns)) {
                    $tasks->orderBy($orderBy, $orderType);
                }
            }
        }

        $tasks = $tasks->get();

        $paginator = new Paginator();
        $paginator->pagination($count, $limit, $page, $lastPage, 3, $_GET);

        $auth = Auth::check();

        View::display('index', compact('tasks', 'paginator', 'auth'));
    }

    public function store()
    {
        $errors = $this->taskValidations();

        if (!empty($errors)) {
            return Response::json([
                'errors' => $errors
            ], 401);
        }

        $task = new Task();
        $task->add([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'text' => $_POST['text']
        ]);

        return Response::json([
            'success' => true,
            'message' => 'Задача успешно добавлена'
        ]);
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $task = new Task();
        $data = $task->select('text,id,status')
            ->where('id', '=', $id)
            ->first();

        if (empty($data)) {
            return Response::error(404, 'Error 404 page not found');
        }

        return View::display('edit', compact('data'));
    }

    public function update($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $task = new Task();
        $data = $task->select('text,edited')
            ->where('id', '=', $id)->first();

        if (empty($data)) {
            return Response::error(404, 'Error 404 page not found');
        }

        $edited = $data['edited'];
        if (trim($data['text']) != trim($_POST['text'])){
            $edited = 1;
        }

        $status = 0;
        if (isset($_POST['status'])){
            $status = 1;
        }

        $task->update([
            'text' => $_POST['text'],
            'edited' => $edited,
            'status' => $status
        ]);

        return redirect('/');
    }

    private function taskValidations()
    {
        $errors = [];
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'email не валиден';
        }

        if (empty(trim($_POST['name']))) {
            $errors['name'] = 'имя не валиден';
        }

        if (empty(trim($_POST['text']))) {
            $errors['text'] = 'текст не валиден';
        }

        return $errors;
    }
}
