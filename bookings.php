<?php
// Initialize the session
session_start();
require_once "Helper.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if (Helper::permission($_SESSION['username'], "order-list") != 1){
    Helper::error('You do not have permission to view this page!');
    die();
}
include 'DB.php';
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <link rel="stylesheet" href="./app/main.css">
</head>
<body>
<h1 class="my-5">Вітаю, <b><?php echo htmlspecialchars($_SESSION["first_name"]); ?></b>. Ласкаво просимо на адмін панель <a href="index.php">PhotoStudio</a></h1>
<p>
    <a href="logout.php" class="btn btn-danger ml-3">Вийти з аккаунту</a>
    <a href="index.php" class="btn btn-primary ml-3">Повернутись на сайт</a>
    <a href="bookings.php" class="btn btn-primary disabled ml-3">Відкрити бронювання</a>
    <a href="services.php" class="btn btn-primary ml-3">Переглянути послуги</a>
</p>
<div class="admin_panel">

    <?php if($result->num_rows > 0): ?>
        <table >

            <tr>
                <th>ID</th>
                <th>Ім'я клієнта</th>
                <th>Прізвище клієнта</th>
                <th>Номер телефону</th>
                <th>Коментар</th>
                <th>Послуга</th>
                <th>Ціна</th>
                <th>Фотограф, який підписався</th>
                <?php
                if (Helper::permission($_SESSION['username'], "order-edit") == 1){
                    echo '<th>Детальніше</th>';
                }
                ?>
            </tr>

            <?php  while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo  $row["id"] ?></td>
                    <td><?php echo  $row["name"] ?></td>
                    <td><?php echo  $row["surname"] ?></td>
                    <td><?php echo  $row["phone"] ?></td>
                    <td><?php echo  $row["comment"]?></td>
                    <?php
                    $services = "SELECT id, name, price FROM services WHERE id = ".$row['service_id'];
                    $result_service = $conn->query($services)->fetch_assoc();
                    ?>
                    <td><?php echo $result_service['name']?></td>
                    <td><?php echo $result_service['price']?></td>
                    <?php if(isset($row["photographer_id"])){
                        $photographer = "SELECT username FROM users WHERE id = ".$row["photographer_id"];
                        $ph_name = $conn->query($photographer)->fetch_assoc();
                        if(Helper::permission($_SESSION['username'], "order-edit") != 1 && $ph_name['username'] == $_SESSION['username']){
                            echo '<td><a href="ph_remove.php?id='.$row["id"].'">'.$ph_name['username'].'</a></td>';
                        }else echo '<td>'.$ph_name['username'].'</td>';
                    }elseif(Helper::permission($_SESSION['username'], "order-edit") != 1 && $result_service['id'] != 2) {
                        echo '<td><a class="btn btn-info ml-3" style="margin: 0" href="ph_accept.php?id='.$row["id"].'">Прийняти</a></td>';
                    }else{
                        echo '<td></td>';
                    }
                    ?>
                    <?php
                    if (Helper::permission($_SESSION['username'], "order-edit") == 1){
                        echo '<td>
                                <a class="btn btn-warning ml-3" style="margin: 0" href="booking_single.php?id='.$row["id"].'">Переглянути</a>
                                <a class="btn btn-danger ml-3" style="margin: 0" href="delete_booking.php?id='.$row["id"].'">Видалити</a>
                              </td>';
                    }
                    ?>
                </tr>
            <?php endwhile; ?>

        </table>

    <?php else: ?>

        <h1>0 Results</h1>

    <?php endif; ?>
</div>
</body>
</html>