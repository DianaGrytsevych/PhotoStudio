<?php
if (!isset($_SESSION)) { session_start(); }
include 'DB.php';
include 'Helper.php';
if (Helper::permission($_SESSION['username'], "order-edit") != 1){
    Helper::error('You do not have permission to view this page!');
    die();
}
$sql = "DELETE FROM books WHERE id = ".$_GET['id'];
if ($conn->query($sql) === TRUE) {
    $conn->close();
    Helper::redirect('bookings.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();