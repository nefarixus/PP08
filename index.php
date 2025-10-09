<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Cantarell:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Бета | СайдКвест</title>
</head>
<body>
    <div class="burger-menu">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <aside>
        <div class="aside-scroll">
            <a href="index.php">
                <div class="logo">
                    <img src="./images/logo.svg" alt="logo">
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
                    <img src="./images/home.svg" alt="navigation icon" class="icon">
                    <a href="./index.php" class="nav-text">Главная</a>
                </div>
                <div class="nav-block">
                    <img src="./images/download.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Установить СайдКвест</a>
                </div>
                <div class="nav-block">
                    <img src="./images/rocket.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Приложения и Игры</a>
                </div>
                <div class="nav-block">
                    <img src="./images/community.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Виртуальные Комнаты</a>
                </div>
                <div class="nav-block">
                    <img src="./images/thunder.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Вступить в альянс</a>
                </div>
                <div class="nav-block">
                    <img src="./images/star.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Выйти в Топ</a>
                </div>
                <div class="nav-block">
                    <img src="./images/question.svg" alt="navigation icon" class="icon">
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
                    <a href="./pages/profile.php" class="account">Мой аккаунт</a>
                    <a href="logout.php" class="account" style="color: #ff4444; border: 0;">Выход</a>
                </div>
            <?php else: ?>
                <!-- Гость -->
                <a href="#"><img src="./images/profile.svg" alt="account picture" class="auth-img"></a>
                <div class="auth-buttons">
                    <a href="pages/login.php" class="login">Войти или <br> Зарегестрироваться</a>
                </div>
            <?php endif; ?>
        </div>
    </aside>
    <div class="page-wrapper">
        <div class="container" id="main-container">
            <main>
                <div class="container-signup-button">
                    <a href="#" class="neon-button">Зарегестрироваться сейчас</a>
                </div>
                <div class="header">
                    <div class="main-header">
                        <div class="slider">
                            <div class="slide" style="background-image: url('./images/LandscapeArcGlyphCoverArt.jpg');">
                                <a href="#">
                                    <div class="banner-card">
                                        <p class="card-title">ArcGlyph</p>
                                        <p class="card-desc">ArcGlyph это утилита смешанной реальности для любых задач: призывайте круги, счетчики, таймеры и процедурных существ в своем пространстве.</p>
                                        <p class="find-out-more">Узнать больше</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide" style="background-image: url('./images/app-image-override.png');">
                                <a href="#">
                                    <div class="banner-card">
                                        <p class="card-title">FortiCasa</p>
                                        <p class="card-desc">Погрузитесь в уникальное стратегическое оборонное приключение с FortiCasa: ВР робот дефенс для Oculus Quest!</p>
                                        <p class="find-out-more">Узнать больше</p>
                                    </div>
                                </a>
                            </div>
                            <div class="slide" style="background-image: url('./images/app-image-override (1).png');">
                                <a href="#">
                                    <div class="banner-card">
                                        <p class="card-title">Metacity Patrol</p>
                                        <p class="card-desc">Исследуйте и защищайте районы Metacity в свободной приключенческой киберпанк-песочнице.</p>
                                        <p class="find-out-more">Узнать больше</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
                        <button class="next" onclick="moveSlide(1)">&#10095;</button>
                    </div>
                    <div class="dots">
                        <span class="dot" onclick="currentSlide(0)"></span>
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                    </div>
                </div>
                <div class="under-header">
                    <div class="second-header">
                        <div class="main-second-header">
                            <div class="slider2">
                                <?php
                                // Подключение к БД
                                $host = '127.0.0.1';
                                $dbname = 'sidequest';
                                $username = 'root';
                                $password_db = '';

                                try {
                                    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password_db);
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                } catch (PDOException $e) {
                                    echo '<div class="slide2"><p>Ошибка подключения к БД</p></div>';
                                    exit;
                                }

                                // Получаем ID игр из библиотеки пользователя (только если авторизован)
                                $user_library = [];
                                if (isset($_SESSION['user_id'])) {
                                    $stmt = $pdo->prepare("
                                        SELECT product_id FROM user_products WHERE user_id = ?
                                    ");
                                    $stmt->execute([$_SESSION['user_id']]);
                                    $user_library = $stmt->fetchAll(PDO::FETCH_COLUMN); // массив ID: [1, 5, 7]
                                }

                                // Получаем все приложения
                                $stmt = $pdo->query("SELECT * FROM products ORDER BY id");
                                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (empty($products)) {
                                    echo '<div class="slide2"><p>Нет доступных приложений</p></div>';
                                } else {
                                    foreach ($products as $product) {
                                        $is_in_library = in_array($product['id'], $user_library);

                                        echo '
                                        <div class="slide2">
                                            <a href="#">
                                                <div class="banner-card2">
                                                    <img src="./images/' . htmlspecialchars($product['img']) . '" alt="banner card" class="card-image">
                                                    <p class="card-desc2">' . htmlspecialchars($product['name']) . '</p>
                                                    <div class="rating"></div>
                                                </div>
                                            </a>
                                            <button type="button" 
                                                    class="add-button" 
                                                    data-product-id="' . $product['id'] . '"
                                                    ' . ($is_in_library ? 'disabled' : '') . '>
                                                ' . ($is_in_library ? 'Уже в библиотеке' : 'Добавить') . '
                                            </button>
                                        </div>';
                                    }
                                }
                                // Последняя карточка — "Хочешь больше?"
                                echo '
                                <div class="slide2">
                                    <a href="#">
                                        <div class="banner-card-more">
                                            <p class="card-desc-more">Хочешь больше?</p>
                                            <p class="button-more">Начни искать</p>
                                        </div>
                                    </a>
                                </div>';
                                ?>
                            </div>
                            <button class="prev2">&#10094;</button>
                            <button class="next2">&#10095;</button>
                        </div>
                    </div>
                </div>
                <div class="card-menu">
                    <a href="#" class="card-menu-card1">
                        <div>
                            <img src="https://cdn.sidequestvr.com/file/2467806/left-large.png" alt="img-card1">
                            <p class="menu-card-text">Лучшее <br><span>ААА ВР Названия!</span></p>
                        </div>
                    </a>
                    <a href="#" class="card-menu-card2">
                        <div >
                            <p class="menu-card-text2">Скидки и <br><span>Распродажа</span></p>
                            <img src="https://cdn.sidequestvr.com/file/2467809/sale-large.png" alt="img-card2">
                        </div>
                    </a>
                    <a href="#" class="card-menu-card3">
                        <div>
                            <p class="menu-card-text2">Самые <br><span>странные ВР игры!</span></p>
                            <img src="https://cdn.sidequestvr.com/file/2467812/weirdest-large.png" alt="img-card3">
                        </div>
                    </a>
                    <a href="#" class="card-menu-card4">
                        <div>
                            <img src="https://cdn.sidequestvr.com/file/2467815/right-large.png" alt="img-card4">
                            <p class="menu-card-text">Лучшее <br><span>Замиксуй реальность</span></p>
                        </div>
                    </a>
                </div>
                <div class="tops-div">
                    <div class="slider4">
                        <a href="#" class="slide4">
                            <div class="tops-card-inside1">
                                <div class="block">
                                    <p class="top-card-title">Топ <span>хоррор</span> игр</p>
                                    <p class="top-card-desc">Наша выборка пяти наистрашнейших игр этой недели...</p>
                                    <p class="slide-button">Напугай меня</p>
                                </div>
                                <img src="./images/char.png-600.png" alt="1st top">
                            </div>
                        </a>
                        <a href="#" class="slide4">
                            <div class="tops-card-inside2">
                                <div class="block">
                                    <p class="top-card-title">Топ 5 <span>кастомных домов</span></p>
                                    <p class="top-card-desc">Хотите как можно скорее оказаться в каком-нибудь уникальном месте <br>в VR?</p>
                                    <p class="slide-button">Посмотреть</p>
                                </div>
                                <img src="./images/char-big.png-600.png" alt="2nd top">
                            </div>
                        </a>
                        <a href="#" class="slide4">
                            <div class="tops-card-inside3">
                                <div class="block">
                                    <p class="top-card-title">Топ 5 СайдКвест <span>Эксклюзивов</span></p>
                                    <p class="top-card-desc">Найди это только на нашей платформе!</p>
                                    <p class="slide-button">Посмотреть</p>
                                </div>
                                <img src="./images/mario-trend.png-600.png" alt="3rd top">
                            </div>
                        </a>
                        <a href="#" class="slide4">
                            <div class="tops-card-inside4">
                                <div class="block">
                                    <p class="top-card-title">Топ 5 <span>фитнесс приложений</span></p>
                                    <p class="top-card-desc">Занимаетесь спортом в виртуальной реальности? Вот несколько <br>интересных занятий...</p>
                                    <p class="slide-button">Посмотреть</p>
                                </div>
                                <img src="./images/trend-fitness.png-600.png" alt="4th top">
                            </div>
                        </a>
                    </div>
                    <button class="prev4">&#10094;</button>
                    <button class="next4">&#10095;</button>
                </div>
                <div class="top-must-plays">
                    <img src="https://cdn.sidequestvr.com/file/2298807/batman-left-v4.png" alt="" class="joker-img">
                    <img src="https://cdn.sidequestvr.com/file/2298808/right.png" alt="" class="zombie-img">
                    <p class="top-title"><span>Топ</span> Мастхевов!</p>
                    <div class="top-must-plays-grid">
                        <a href="#" class="top-grid1">
                            <div class="top-grid-text-container1">
                                <p class="text1">Бэтмен: Тени Аркхэма</p>
                                <p class="text2">Платно</p>
                            </div>
                        </a>
                        <a href="#" class="top-grid2">
                            <img src="https://cdn.sidequestvr.com/file/2491141/39031485_1160489718016281_3050468458242801597_n.jpg" alt="">
                            <div class="top-grid-text-container">
                                <p class="text1">BONELAB</p>
                                <p class="text2">Платно</p>
                            </div>
                        </a>
                        <a href="#" class="top-grid3">
                            <img src="https://cdn.sidequestvr.com/file/2490798/39031497_875215037171957_3000930639070807095_n.jpg" alt="">
                            <div class="top-grid-text-container">
                                <p class="text1">Assassin's Creed® Nexus</p>
                                <p class="text2">Платно</p>
                            </div>
                        </a>
                    </div>
                    <a class="link" href="#">Покажите мне больше!</a>
                </div>
                <div class="last-container">
                    <div class="last-container-banner">
                        <img src="https://cdn.sidequestvr.com/file/2489194/star-wars-beyond-victory-ilm-meta-immersive-copy.jpg" alt="">
                        <p class="article-text">Добро пожаловать в СайдКвест! Ознакомьтесь с нашими</p>
                        <p class="article-title">Статья — Star Wars: Beyond Victory — раскрыты режим игры и дата выхода</p>
                        <p class="article-who-time">от Татьяна СайдКвест --- 11 сентября 2025 г.</p>
                        <a href="#" class="article-link">Прочитать статью</a>
                    </div>
                    <div class="fifth-slider">
                        <div class="last-container-slider">
                            <a href="#" class="slide5">
                                <div class="tops-card-inside5">
                                    <div class="block">
                                        <p class="top-card-title5"><span>Все приложения</span></p>
                                    </div>
                                    <img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="3rd top">
                                </div>
                            </a>
                            <a href="#" class="slide5">
                                <div class="tops-card-inside5">
                                    <div class="block">
                                        <p class="top-card-title5"><span>Все приложения</span></p>
                                    </div>
                                    <img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="3rd top">
                                </div>
                            </a>
                            <a href="#" class="slide5">
                                <div class="tops-card-inside5">
                                    <div class="block">
                                        <p class="top-card-title5"><span>Все приложения</span></p>
                                    </div>
                                    <img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="3rd top">
                                </div>
                            </a>
                            <a href="#" class="slide5">
                                <div class="tops-card-inside5">
                                    <div class="block">
                                        <p class="top-card-title5"><span>Все приложения</span></p>
                                    </div>
                                    <img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="3rd top">
                                </div>
                            </a>
                            <a href="#" class="slide5">
                                <div class="tops-card-inside5">
                                    <div class="block">
                                        <p class="top-card-title5"><span>Все приложения</span></p>
                                    </div>
                                    <img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="3rd top">
                                </div>
                            </a>
                            <a href="#" class="slide5">
                                <div class="tops-card-inside5">
                                    <div class="block">
                                        <p class="top-card-title5"><span>Все приложения</span></p>
                                    </div>
                                    <img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="3rd top">
                                </div>
                            </a>
                            <a href="#" class="slide5">
                                <div class="tops-card-inside5">
                                    <div class="block">
                                        <p class="top-card-title5"><span>Все приложения</span></p>
                                    </div>
                                    <img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="3rd top">
                                </div>
                            </a>
                            <a href="#" class="slide5">
                                <div class="tops-card-inside5">
                                    <div class="block">
                                        <p class="top-card-title5"><span>Все приложения</span></p>
                                    </div>
                                    <img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="3rd top">
                                </div>
                            </a>
                            <a href="#" class="slide5">
                                <div class="tops-card-inside5">
                                    <div class="block">
                                        <p class="top-card-title5"><span>Все приложения</span></p>
                                    </div>
                                    <img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="3rd top">
                                </div>
                            </a>
                        </div>
                        <button class="prev5">&#10094;</button>
                        <button class="next5">&#10095;</button>
                    </div>
                </div>
                <footer>
                <div class="left-footer-div">
                    <img src="./images/khronos.png" alt="khronos">
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
                    <a href="#"><img src="./images/logo-facebook.png" alt=""></a>
                    <a href="#"><img src="./images/logo-instagram.png" alt=""></a>
                    <a href="#"><img src="./images/logo-reddit.png" alt=""></a>
                    <a href="#"><img src="./images/ri_twitter-x-line.png" alt=""></a>
                    <a href="#"><img src="./images/mdi_youtube.png" alt=""></a>
                    <a href="#"><img src="./images/logo-tiktok.png" alt=""></a>
                    <a href="#"><img src="./images/logo-linkedin.png" alt=""></a>
                </div>

            </footer>
            </main>
        </div>
    </div>
    
    <div class="overlay"></div>
    <script src="./scripts/script.js"></script>
</body>
</html>