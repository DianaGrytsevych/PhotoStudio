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
$sql = "SELECT * FROM books WHERE id = ".$_GET['id'];
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking</title>
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
        <a href="services.php" class="btn btn-primary ml-3">Переглянути послуги</a>
    </p>
</div>
<div class="admin_panel" style="margin: 0 auto; width:20%">
    <form action="update_booking.php" method="post">
        <?php  while($row = $result->fetch_assoc()): ?>
            <input type="hidden" name="id" value="<?php echo $row['id']?>">
            <div class="form-group" style="text-align: left">
                <label for="last_name">Прізвище</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $row['surname']?>">
            </div>
            <div class="form-group" style="text-align: left">
                <label for="first_name">Ім'я</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $row['name']?>">
            </div>
            <div class="form-group" style="text-align: left">
                <label for="phone">Номер телефону</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']?>">
            </div>
            <div class="form-group" style="text-align: left">
                <label for="comment">Коментар</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"><?php echo $row['comment']?></textarea>
            </div>
            <?php if(isset($row['photographer_id'])):?>
            <div class="form-group" style="text-align: left">
                <label for="photographer">Фотограф</label>
                <?php $photographer = "SELECT * FROM users WHERE id = ".$row['photographer_id'];
                $result_photographer = $conn->query($photographer)->fetch_assoc();
                ?>
                <input type="text" readonly class="form-control" id="photographer" value="<?php echo $result_photographer['username']?>">
            </div>
            <?php endif;?>
            <?php
            $services = "SELECT * FROM services WHERE id = ".$row['service_id'];
            $result_service = $conn->query($services)->fetch_assoc();
            ?>
            <div class="form-group" style="text-align: left">
                <?php
                $services_all = "SELECT * FROM services";
                $single_service = $conn->query($services_all);
                ?>
                <label for="service_name">Послуга</label>
                <select style="height: 50px; margin: 10px 0 10px 0; width: 100%" id="service" name="service">
                    <?php  while($row_s = $single_service->fetch_assoc()): ?>
                        <option value="<?php echo $row_s['id']?>"><?php echo $row_s['name']?></option>
                    <?php endwhile;?>
                </select>
            </div>
            <div class="form-group" style="text-align: left">
                <label for="service_price">Ціна</label>
                <input type="text" readonly class="form-control" id="service_price" value="<?php echo $result_service['price']?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" style="margin: 0" value="Змінити">
            </div>
        <?php endwhile;?>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
