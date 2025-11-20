<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === "admin" && $password === "123") {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
    exit;
} else {
    echo "Login gagal! <br><a href='index.php'>Coba lagi</a>";
}