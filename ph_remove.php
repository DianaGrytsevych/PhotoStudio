<?php
if (!isset($_SESSION)) { session_start(); }
include 'DB.php';
include 'Helper.php';
var_dump($_GET['id'], $_SESSION["id"], $_SESSION['first_name']);
if (Helper::permission($_SESSION['username'], "order-list") != 1){
    Helper::error('You do not have permission to view this page!');
    die();
}
$sql = "UPDATE books SET photographer_id = NULL WHERE id = ".$_GET['id'];
if ($conn->query($sql) === TRUE) {
    $conn->close();
    Helper::redirect('bookings.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
