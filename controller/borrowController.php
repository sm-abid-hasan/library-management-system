<?php
session_start();
require_once("../model/bookModel.php");
require_once("../model/borrowModel.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST['book_id'];
    $quantity = (int)$_POST['quantity'];

    
    date_default_timezone_set('Asia/Dhaka');

    
    if (!isset($_SESSION["email"])) {
        $_SESSION["borrow_message"] = "You must be logged in to borrow a book.";
        header("Location: ../view/loginView.php");
        exit();
    }

    $email = $_SESSION["email"];

    
    if ($quantity >= 1 && reduceBookQuantity($bookId)) {

        
        $borrowedDate = date("Y-m-d");
        $returnDate = date("Y-m-d", strtotime("+3 days"));

        
        insertBorrowedBook($bookId, $borrowedDate, $returnDate, $email);

        $_SESSION["borrow_message"] = "Successfully done";
    } else {
        $_SESSION["borrow_message"] = "Invalid request";
    }

    
    header("Location: ../view/searchResult.php");
    exit();
}
?>