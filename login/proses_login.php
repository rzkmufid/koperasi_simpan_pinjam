<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username' AND password_hashed='$password'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $row['level'];
        header("Location: ../");
    } else {
        echo "Login Gagal";
    }
}

$conn->close();
