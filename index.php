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
                        <input type="text" placeholder="Поиск по СайдКвесту..." id="searchInput"/>
                    </div>
                </form>
            </div>
            <nav class="primary-nav">
                <div class="nav-block">
                    <img src="./images/home.svg" alt="navigation icon" class="icon">
                    <a href="#" class="nav-text">Главная</a>
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
            <a href="#"><img src="./images/profile.svg" alt="account picture" class="auth-img"></a>
            <div class="auth-buttons">
                <a href="#" class="login">Войти или <br> Зарегестрироваться</a>
                <a href="#" class="account">Мой аккаунт</a>
            </div>
        </div>
    </aside>
    <div class="container">
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
                                    <p class="card-desc">ArcGlyph is a mixed-reality utility for Quest: summon circles, counters, timers, and procedural creatures in your space</p>
                                    <p class="find-out-more">Find out more</p>
                                </div>
                            </a>
                        </div>
                        <div class="slide" style="background-image: url('./images/app-image-override.png');">
                            <a href="#">
                                <div class="banner-card">
                                    <p class="card-title">FortiCasa</p>
                                    <p class="card-desc">Immerse yourself in a unique strategic defense adventure with FortiCasa: AR Robot Defense for Oculus Quest!</p>
                                    <p class="find-out-more">Find out more</p>
                                </div>
                            </a>
                        </div>
                        <div class="slide" style="background-image: url('./images/app-image-override (1).png');">
                            <a href="#">
                                <div class="banner-card">
                                    <p class="card-title">Metacity Patrol</p>
                                    <p class="card-desc">Explore and protect the districts of Metacity in a free roaming, cyberpunk sandbox adventure.</p>
                                    <p class="find-out-more">Find out more</p>
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
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/Listing_play_for_free.jpg" alt="banner card" class="card-image">
                                        <p class="card-desc2">Jolly Match-3 в ВР!</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/copy-of-meta_asset_cover_trailer_2560x1440_only.png" alt="banner card" class="card-image">
                                        <p class="card-desc2">Maestro</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/banter_new_listing_v3_copy-1-1.png" alt="banner card" class="card-image">
                                        <p class="card-desc2">BANTER</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/app-lab-cover-art-landscape_new.png" alt="banner card" class="card-image">
                                        <p class="card-desc2">Metacity patrol</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/38974446_1776802149753873_1245728995774615929_n.jpg" alt="banner card" class="card-image">
                                        <p class="card-desc2">Cave Crave</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/oktoberfest-rides-store-cover-square.png" alt="banner card" class="card-image">
                                        <p class="card-desc2">Oktoberfest</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/mym_landscape_2560x1440.png" alt="banner card" class="card-image">
                                        <p class="card-desc2">My Monsters</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/499307426_1707159933498868_8457147349349778285_n.jpg" alt="banner card" class="card-image">
                                        <p class="card-desc2">Grit and Valor</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/499617803_2485113945220600_1576221352827465812_n.jpg" alt="banner card" class="card-image">
                                        <p class="card-desc2">Frost Survival ВР</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card2">
                                        <img src="./images/sidequesta2listingimage.png" alt="banner card" class="card-image">
                                        <p class="card-desc2">Arcaxer 2</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide2">
                                <a href="#">
                                    <div class="banner-card-more">
                                        <p class="card-desc-more">Хочешь больше?</p>
                                        <a href="#" class="button-more">Начни искать</a>
                                    </div>
                                </a>
                            </div>
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
                <a href=""# class="card-menu-card3">
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
            <div class="under-header">
                <div class="third-header">
                    <div class="main-third-header">
                        <div class="slider3">
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/Listing_play_for_free.jpg" alt="banner card" class="card-image">
                                        <p class="card-desc3">Jolly Match-3 в ВР!</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/copy-of-meta_asset_cover_trailer_2560x1440_only.png" alt="banner card" class="card-image">
                                        <p class="card-desc3">Maestro</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/banter_new_listing_v3_copy-1-1.png" alt="banner card" class="card-image">
                                        <p class="card-desc3">BANTER</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/app-lab-cover-art-landscape_new.png" alt="banner card" class="card-image">
                                        <p class="card-desc3">Metacity patrol</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/38974446_1776802149753873_1245728995774615929_n.jpg" alt="banner card" class="card-image">
                                        <p class="card-desc3">Cave Crave</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/oktoberfest-rides-store-cover-square.png" alt="banner card" class="card-image">
                                        <p class="card-desc3">Oktoberfest</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/mym_landscape_2560x1440.png" alt="banner card" class="card-image">
                                        <p class="card-desc3">My Monsters</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/499307426_1707159933498868_8457147349349778285_n.jpg" alt="banner card" class="card-image">
                                        <p class="card-desc3">Grit and Valor</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/499617803_2485113945220600_1576221352827465812_n.jpg" alt="banner card" class="card-image">
                                        <p class="card-desc3">Frost Survival ВР</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card3">
                                        <img src="./images/sidequesta2listingimage.png" alt="banner card" class="card-image">
                                        <p class="card-desc3">Arcaxer 2</p>
                                        <div class="rating"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="slide3">
                                <a href="#">
                                    <div class="banner-card-more">
                                        <p class="card-desc-more">Хочешь больше?</p>
                                        <a href="#" class="button-more">Начни искать</a>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <button class="prev3">&#10094;</button>
                        <button class="next3">&#10095;</button>
                    </div>
                </div>
            </div>
        </main>
        <footer>

        </footer>
    </div>

    <script src="./scripts/script.js"></script>
</body>
</html>