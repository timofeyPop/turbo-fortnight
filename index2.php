<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Главная страница</title>
  <style>
    body{
        background-color: #99FFCC;
    }
 </style>
  <link rel="stylesheet" href="style_main.css">
</head>
<body>
<div id="home" class="w3-content">

<header>
        <a href="#" class="logo">Pizza Pie</a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <ul class="navbar">
            <a id="loginBtn" href="#home">Сменить пользователя</a>
            <a href="#menu">Меню</a>
            <a id="loginBtn1" href="#home">Посмотреть погоду</a>
            <a href="full.php">Просмотреть таблицы</a>
            <a href="sql.php">Написать запрос</a>
            <a href="table1.php">Таблица:pizza</a>
            <a href="table2.php">Таблица:klient</a>
            <a href="t2.php">Отчет</a>
          
        
        </ul>
    </header>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Добро пожаловать </h1>            
            <form method="post" action="login.php">
                <input type="text" name="username" placeholder="Логин">
                <input type="password" name="password" placeholder="Пароль">
                <input type="submit" value="Войти">
            </form>
        </div>
    </div>

    <div id="loginModal1" class="modal1">
        <div class="modal-content1">
            <span class="close1">&times;</span>
            <a class="nuipogoda-iframe-informer" data-nuipogoda="informer2" href="https://nuipogoda.ru" style="width:284px;height:326px;display:block;box-shadow: 0 0 5px #999;">НУ И ПОГОДА</a><script>(function(a,f,g){var e=a.createElement(f);e.async=1;e.src=g; a=a.getElementsByTagName(f)[0];a.parentNode.insertBefore(e,a)})(document,'script','//nuipogoda.ru/informer/nuipogoda.js');</script>
   
    
        </div>
    </div>
  
    
    <section class="home" id="home">
        <div class="home-text">
            <h1>Доставка Пиццы</h1>        
        </div>
        <div class="home-img">
            <img src="home.jpg" alt="">
        </div>
    </section>

    <section class="menu" id="menu">
        <div class="heading">
            <span>МЕНЮ</span>
            <h2>Лучшее для лучших</h2>
        </div>
        <div class="menu-container">
            <!-- Box 1 -->
            <div class="box">
                <div class="box-img">
                    <img src="2.jpg" alt="">
                </div>
                <h2>Пицца 4 сыра</h2>
                <h3>Горгондзола, моцарелла,<br> фонтина и пармезан</h3>
                <span>От 600</span>
                <i class='bx bx-cart-alt'></i>
            </div>
            <!-- Box 2 -->
            <div class="box">
                <div class="box-img">
                    <img src="3.avif" alt="">

                </div>
                <h2>Пицца пеперони</h2>
                <h3>Cвинина,говядина,<br> паприка,острый перец</h3>
                <span>От 500</span>
                <i class='bx bx-cart-alt'></i>
            </div>
            <!-- Box 3 -->
            <div class="box">
                <div class="box-img">
                    <img src="5.jpg" alt="">
                </div>
                <h2>Пицца маргарита</h2>
                <h3>Дрожжевое тесто, оливковое масло,<br> томаты, листья базилика, моцарелла</h3>
                <span>От 550</span>
                <i class='bx bx-cart-alt'></i>
            </div>
            
    </section>


     <!-- Contact -->
     <section class="contact" id="contact">
       
        <div class="contact-box address">
            <h3>Контакты</h3>
            <i class='bx bxs-map' ><span>МГТУ ГА</span></i>
            <i class='bx bxs-phone' ><span>+7-(966)-020-28-94</span></i>
            <i class='bx bxs-envelope' ><span>popot2003@mail.ru</span></i>
        </div>
    </section>
    
 <!-- Copyright -->
 <div class="copyright">
        <p>© Сделано в России</p>
    </div>
    <!-- Scroll Reveal -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <!-- Link To JavaScript -->
    <script src="script.js"></script>

 

    <script>
        var modal1 = document.getElementById("loginModal1");
        var btn1 = document.getElementById("loginBtn1");
        var span1 = document.getElementsByClassName("close1")[0];

        btn1.onclick = function() {
            modal1.style.display = "flex";
        }

        span1.onclick = function() {
            modal1.style.display = "none";
        }

        window1.onclick = function(event) {
            if (event.target == modal1) {
                modal1.style.display = "none";
            }
        }
    </script>
<script>
        var modal = document.getElementById("loginModal");
        var btn = document.getElementById("loginBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "flex";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
   

</body>
</html>
