<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}

include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $level = $_POST["level"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $result = $conn->query("INSERT INTO users (username, password_hashed, level) VALUES ('$username', '$hashed_password', '$level')");

    if ($result === TRUE) {
        echo '<script language="javascript">';
        echo 'alert(Pengguna berhasil ditambahkan.)';  //not showing an alert box.
        echo '</script>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
    }
}

$conn->close();
