<?php
// Initialize the session
session_start();
require_once "Helper.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if (Helper::permission($_SESSION['username'], "service-list") != 1){
    Helper::error('You do not have permission to view this page!');
    die();
}
include 'DB.php';
$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <link rel="stylesheet" href="./app/main.css">
</head>
<body>
<div>
    <h1 class="my-5">Вітаю, <b><?php echo htmlspecialchars($_SESSION["first_name"]); ?></b>. Ласкаво просимо на адмін панель <a href="index.php">PhotoStudio</a></h1>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Вийти з аккаунту</a>
        <a href="index.php" class="btn btn-primary ml-3">Повернутись на сайт</a>
        <a href="bookings.php" class="btn btn-primary ml-3">Відкрити бронювання</a>
        <a href="services.php" class="btn btn-primary disabled ml-3">Переглянути послуги</a>
    </p>
    <div class="admin_panel">
    <?php if($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Ціна</th>
            <th>Опис</th>
        </tr>
        <?php  while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['name']?></td>
            <td><?php echo $row['price']?></td>
            <td><?php echo $row['detail']?></td>
        </tr>
        <?php endwhile;?>
    </table>
    <?php endif;?>
    </div>
</div>
</body>
</html>