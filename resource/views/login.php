<?php include 'head.php' ?>
<div class="container-fluid vh-100 text-center d-flex align-items-center justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <form action="/login" method="post">
                <div class="card-header">
                    <h3>Вход</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$error?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input type="text" name="login" class="form-control" id="login">
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="text" name="password" class="form-control" id="password">
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Войти</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'scripts.php' ?>

