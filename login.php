<?php
session_start();
include 'connection.php';

if (isset($_POST['submit'])) {
    $username = $_POST['userrname'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'admin@2024') {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_name'] = 'admin';
        header("Location: dashboard.html");
        exit();
    } else {
        header("location: index.html");
        exit();
    }
} else {

    header("Location: dashboard.html");
    exit();
}
?>