<?php
use classes\DBHandler;

require_once 'vendor/autoload.php';
try {
    $db = new DBHandler('/config/db.php');
    $comments = $db->getData();
} catch (Exception $e) {
     die($e->getMessage());
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HoneyHunter</title>
    <link rel="stylesheet" href="static/css/bootstrap.css">
    <link href="static/css/style.css" rel="stylesheet">
</head>
<body>
<header class="container-fluid">
    <div class="container">
        <div class="logo"><a href="/"><img src="static/img/logo1.png" alt=""></a></div>
        <img src="static/img/ContactIcon.png" alt="ContactIcon" class="contactIcon">
        <form action="/" class="row justify-content-center" id="needs-validation" novalidate>
            <div class="col-md-6 form-items">
                <label for="name">
                    Имя*
                    <input type="text" class="form-control" name="name" minlength="3" id="name" value="" required>
                    <span class="invalid-feedback">
                        Имя должно состоять минимум из двух символов
                    </span>
                </label>
                <label for="email" id="email-label">
                    E-mail*
                    <input type="text" class="form-control" name="email" id="email" value=""
                           pattern="[a-zA-Z0-9s.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]{2,8})$" required>
                    <span class="invalid-feedback">
                        Пожалуйста заполните коректно Email
                    </span>
                </label>
            </div>
            <div class="col-md-6 form-items">
                <label for="comments">
                    Комментарий*
                    <textarea name="comment" class="form-control" id="comments" minlength="4" required></textarea>
                    <span class="invalid-feedback">
                        Комментарий должен состоять минимум из 4-ёх символов
                    </span>
                </label>
                <button type="submit" id="send">Записать</button>
            </div>
        </form>
    </div>
    <div class="info-msg"></div>
</header>
<main>
    <section id="massages" class="container">
        <h2>Выводим комментарии</h2>
        <div class="cards">
            <?php
            /** @var array $comments */
            foreach ($comments as $comment): ?>
                <article class="card">
                    <h3><?= $comment['name'] ?></h3>
                    <div class="container">
                        <p class="email"><?= $comment['email'] ?></p>
                        <p class="msg"><?= $comment['comment'] ?></p>
                    </div>
                </article>
            <?php
            endforeach; ?>
        </div>
    </section>
</main>
<footer class="container-fluid">
    <ul class="container">
        <li class="logo"><a href="#"><img src="static/img/logo2.png" class="img-fluid" alt="logo" width="210"
                                          height="42"></a></li>
        <li>
            <ul>
                <li class="social"><a href="#"><img src="static/img/vk.png" alt="vk" width="22" height="12"></a></li>
                <li class="social"><a href="#"><img src="static/img/fb.png" alt="fb" width="10" height="18"></a></li>
            </ul>
        </li>
    </ul>
</footer>
<script src="static/js/main.js"></script>

</body>
</html>
