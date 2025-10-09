<?php
    session_start();
    $show_success = false;

    if (isset($_GET['registered']) && isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
        $show_success = true;
        $email = htmlspecialchars($_SESSION['registered_email']);
        unset($_SESSION['registration_success'], $_SESSION['registered_email']);
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Cantarell:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Бета | СайдКвест</title>
</head>
<body>
    <aside>
        <div class="aside-scroll">
            <a href="../index.php">
                <div class="logo">
                    <img src="../images/logo.svg" alt="logo">
                    <p class="logo-text">СайдКвест</p>
                </div>
            </a>
            <div class="search">
                <form action="?" method="post">
                    <div class="search-box">
                        <input type="text" placeholder="Поиск по СайдКвесту..." id="searchInput"/>
                    </div>
                </form>
            </div>
            <nav class="primary-nav">
                <div class="nav-block">
                    <img src="../images/home.svg" alt="navigation icon" class="icon">
                    <a href="../index.php" class="nav-text">Главная</a>
                </div>
                <div class="nav-block">
                    <img src="../images/download.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Установить СайдКвест</a>
                </div>
                <div class="nav-block">
                    <img src="../images/rocket.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Приложения и Игры</a>
                </div>
                <div class="nav-block">
                    <img src="../images/community.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Виртуальные Комнаты</a>
                </div>
                <div class="nav-block">
                    <img src="../images/thunder.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Вступить в альянс</a>
                </div>
                <div class="nav-block">
                    <img src="../images/star.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Выйти в Топ</a>
                </div>
                <div class="nav-block">
                    <img src="../images/question.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Поддержка</a>
                </div>
            </nav>
            <nav class="secondary-nav">
                <a href="#" class="nav-text">Портал для разработчиков</a>
                <a href="#" class="nav-text">Обратная связь</a>
                <a href="#" class="nav-text">О нас</a>
            </nav>
        </div>
        <div class="banner-add">
            <p>здесь могла бы быть ваша реклама</p>
        </div>
        <div class="auth">
            <a href="#"><img src="../images/profile.svg" alt="account picture" class="auth-img"></a>
            <div class="auth-buttons">
                <a href="#" class="login">Войти или <br> Зарегестрироваться</a>
                <a href="#" class="account">Мой аккаунт</a>
            </div>
        </div>
    </aside>
    <div class="container">
        <main>
            <div class="main-login">
                <div class="login-container">
                    <h2>Войдите сейчас, чтобы исследовать...</h2>

                    <form action="../auth.php" method="post">
                        <div class="form-group">
                            <label for="email">Какая у вас почта?</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Какой у вас пароль?</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                        <a href="#" class="forgot-password">Забыли пароль?</a>

                        <div class="btn-group">
                            <button type="submit" class="btn-login">Войти</button>
                            <div class="social-icons">
                                <div class="social-btn"><img src="../images/ic_baseline-discord.png" alt="Discord"></div>
                                <div class="social-btn"><img src="../images/mdi_github.png" alt="Steam"></div>
                                <div class="social-btn"><img src="../images/flowbite_google-solid.png" alt="Google"></div>
                            </div>
                        </div>
                    </form>

                    <div class="login-footer">
                        <p>Нет аккаунта?</p>
                        <a href="reg.php">Создайте здесь!</a>
                    </div>
                </div>
            </div>
            <footer>
            <div class="left-footer-div">
                <img src="../images/khronos.png" alt="khronos">
                <ul>
                    <li><a href="#">Настройки файлов cookie</a></li>
                    <li><a href="#">Условия использования</a></li>
                    <li><a href="#">Конфиденциальность</a></li>
                    <li><a href="#">Присоединяйтесь к команде</a></li>
                    <li><a href="#">Продвигайте с нами</a></li>
                    <li><a href="#">Предложить приложение</a></li>
                </ul>
            </div>
            <div class="right-footer-div">
                <a href="#"><img src="../images/logo-facebook.png" alt=""></a>
                <a href="#"><img src="../images/logo-instagram.png" alt=""></a>
                <a href="#"><img src="../images/logo-reddit.png" alt=""></a>
                <a href="#"><img src="../images/ri_twitter-x-line.png" alt=""></a>
                <a href="#"><img src="../images/mdi_youtube.png" alt=""></a>
                <a href="#"><img src="../images/logo-tiktok.png" alt=""></a>
                <a href="#"><img src="../images/logo-linkedin.png" alt=""></a>
            </div>
        </footer>
        </main>
    </div>

    <script src="../scripts/script.js"></script>
</body>
</html>