<?php include "head.php"; ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">beejee Test app</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#addTaskModal">Добавить
                            задачу</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Сортировка
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= getUrl() ?>?orderby=name&ordertype=ASC">По возрастанию
                                имени</a>
                            <a class="dropdown-item" href="<?= getUrl() ?>?orderby=name&ordertype=DESC">По убыванию
                                имени</a>
                            <a class="dropdown-item" href="<?= getUrl() ?>?orderby=email&ordertype=ASC">По возрастанию
                                email</a>
                            <a class="dropdown-item" href="<?= getUrl() ?>?orderby=email&ordertype=DESC">По убыванию
                                email</a>
                            <a class="dropdown-item" href="<?= getUrl() ?>?orderby=status&ordertype=ASC">По возрастанию
                                статус</a>
                            <a class="dropdown-item" href="<?= getUrl() ?>?orderby=status&ordertype=DESC">По убыванию
                                статус</a>
                        </div>
                    </li>
                </ul>
                <?php if ($auth): ?>
                    <form action="/logout" method="post">
                        <input type="submit" class="btn btn-danger" value="Выход">
                    </form>
                <?php else: ?>
                    <a href="/login" class="btn btn-primary">Войти</a>
                <?php endif ?>
            </div>
        </div>
    </nav>
</header>
<div class="container mt-5 mb-5">
    <div class="d-flex flex-column  align-items-center">
        <?php foreach ($tasks as $task): ?>
            <div class="mt-2 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                            <h5 class="mr-4 text-break"><?= strip_tags($task['email']) ?></h5>
                            <?php if ($task['status'] == 1): ?>
                                <span class="text-break text-success">выполнено</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body text-break">
                        <h5><?= strip_tags($task['name']) ?></h5>
                        <?= strip_tags($task['text']) ?>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4">
                                <?php if ($auth): ?>
                                    <a href="/task/<?= $task['id'] ?>">Редактировать</a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <?php if ($task['edited'] == 1): ?>
                                    <span class="text-primary">отредактировано администратором</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-center mt-2">
        <?= $paginator->render() ?>
    </div>
</div>

<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/store" id="addTaskForm" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить задачу</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="text">Текст</label>
                        <textarea class="form-control" name="text" id="text" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include 'scripts.php' ?>

