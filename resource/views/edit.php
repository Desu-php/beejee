<?php include 'head.php'?>
    <div class="container mt-5">
        <div class="col-md-6 offset-3">
            <form action="/task/update/<?=$data['id']?>" method="post">
                <div class="form-group">
                    <label for="text">Текст</label>
                    <textarea id="text" name="text" class="form-control" required><?=$data['text']?></textarea>
                </div>
                <div class="form-check">
                    <input type="checkbox" <?= $data['status'] == 1?"checked='true'":''?> class="form-check-input" id="finish" name="status">
                    <label class="form-check-label" for="finish">выполнено</label>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Сохранить</button>
            </form>
        </div>
    </div>
<?php include 'scripts.php'?>
