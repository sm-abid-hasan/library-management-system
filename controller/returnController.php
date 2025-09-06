<?php
session_start();
require_once("../model/borrowModel.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrowId = $_POST["borrow_id"];
    $bookId = $_POST["book_id"];

    
    $marked = markAsReturned($borrowId);

    
    $increased = increaseBookQuantity($bookId);

    
    if ($marked && $increased) {
        $_SESSION["return_message"] = "Successfully done";
    } else {
        $_SESSION["return_message"] = "Something went wrong. Please try again.";
    }

    
    header("Location: ../view/returnView.php");
    exit();
} else {
    
    $_SESSION["return_message"] = "Invalid request.";
    header("Location: ../view/returnView.php");
    exit();
}
