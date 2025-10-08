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
                    <input type="text" placeholder="Поиск по СайдКвесту..." id="searchInput">
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
        <?php
        session_start();
        if (isset($_SESSION['user_id'])): ?>
            <!-- Пользователь авторизован -->
            <div class="auth-buttons">
                <p class="login"><?= htmlspecialchars($_SESSION['login']) ?></p>
                <a href="./profile.php" class="account">Мой аккаунт</a>
                <a href="../logout.php" class="account" style="color: #ff4444; border: 0;">Выход</a>
            </div>
        <?php else: ?>
            <!-- Гость -->
            <a href="#"><img src="./images/profile.svg" alt="account picture" class="auth-img"></a>
            <div class="auth-buttons">
                <a href="pages/login.php" class="login">Войти или <br> Зарегестрироваться</a>
                <a href="#" class="account">Мой аккаунт</a>
            </div>
        <?php endif; ?>
    </div>
</aside>