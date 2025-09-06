<?php
session_start();
require_once("../model/borrowModel.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrowId = $_POST["borrow_id"];
    $bookId = $_POST["book_id"];

    $markReturned = markAsReturned($borrowId);
    $increaseQty = increaseBookQuantity($bookId);

    if ($markReturned && $increaseQty) {
        $_SESSION['overdue_msg'] = "Successfully done";
    } else {
        $_SESSION['overdue_msg'] = "Error: Something went wrong.";
    }

    header("Location: ../view/overdueView.php");
    exit();
}
