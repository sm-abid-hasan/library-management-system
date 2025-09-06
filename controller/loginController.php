<?php
session_start();
require_once("../model/usersModel.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $result = checkLogin($email, $password);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $user["name"];
        $_SESSION["email"] = $user["email"];
        header("Location: ../view/home.php");
        exit;
    } else {
        $_SESSION["login_error"] = "Invalid email or password";
        header("Location: ../view/loginView.php");
        exit;
    }
}
?>