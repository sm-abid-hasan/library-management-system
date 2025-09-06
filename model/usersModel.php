<?php
require_once("../db.php");

function insertuser($name, $email, $pass) {
    $conn = getConnection();
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";
    return mysqli_query($conn, $sql);
}

function checkLogin($email, $pass) {
    $conn = getConnection();
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    return mysqli_query($conn, $sql);
}

function getUserByEmail($email) {
    $conn = getConnection();
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result); 
}
?>
