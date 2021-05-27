<?php
// Initialize the session
session_start();
include 'Helper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoStudio</title>
    <link rel="stylesheet" href="./app/main.css">
</head>
    
    <header>
            <div class="container header">
                <img class="logo" src="./app/img/logo.png" alt="PhotoStudio">
                <nav>
                    <ul class="nav">
                        <li class="nav_links"><a href="/index.php">головна</a></li>
                        <li class="nav_links"><a href="/art_one.php">інтер'єр</a></li>
                        <li class="nav_links"><a href="/price.php">ціни</a></li>
                        <li class="nav_links"><a href="/book.php">бронювання</a></li>
                        <li class="nav_links"><a href="/callback.php">зв'язок із нами</a></li>
                    </ul>
                </nav>
                <div class="languges">
                    <?php if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true): ?>
                        <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"><?php echo htmlspecialchars($_SESSION["first_name"]); ?></button>
                            <div id="myDropdown" class="dropdown-content">
                                <?php if(Helper::permission($_SESSION['username'], "order-list") == 1):?>
                                <a href="welcome.php">Адмін панель</a>
                                <?php endif;?>
                                <a href="logout.php">Вийти</a>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                        echo '<a href="/login.php">Увійти</a> / <a href="/register.php">Зареєструватись</a>';
                    } ?>
                </div>
            </div>
    </header>
<script>
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>