<?php
if (!isset($_SESSION)) { session_start(); }
include 'DB.php';
include 'Helper.php';
var_dump($_SESSION['username']);
if (Helper::permission($_SESSION['username'], "order-edit") != 1){
    Helper::error('You do not have permission to view this page!');
    die();
}
if (isset($_POST["last_name"]) &&
    isset($_POST["first_name"]) &&
    isset($_POST["phone"])&&
    isset($_POST["comment"])){
    $sql = "UPDATE books SET surname = '".$_POST["last_name"]."', name = '".$_POST["first_name"]."', phone = '".$_POST["phone"]."', comment = '".$_POST["comment"]."', service_id = '".$_POST["service"]."'  WHERE id = ".$_POST["id"];
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        Helper::redirect('bookings.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
