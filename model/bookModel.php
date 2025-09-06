<?php
require_once("../db.php");


function getBookById($bookId) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


function searchBooks($searchText) {
    $conn = getConnection();
    $search = "%" . $searchText . "%";

    $sql = "SELECT * FROM books 
            WHERE title LIKE ? 
               OR author LIKE ? 
               OR isbn LIKE ? 
               OR shelf LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $search, $search, $search, $search);
    $stmt->execute();
    return $stmt->get_result();
}

function reduceBookQuantity($bookId) {
    $conn = getConnection();
    $sql = "UPDATE books SET quantity = quantity - 1 WHERE id = ? AND quantity > 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    return $stmt->execute();
}
