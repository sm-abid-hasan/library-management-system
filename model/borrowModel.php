<?php
require_once("../db.php");


function getAllBorrowedBooks() {
    $conn = getConnection();
    $sql = "SELECT * FROM borrowed_books WHERE status = 'borrowed' ORDER BY borrowed_date DESC";
    return mysqli_query($conn, $sql);
}



function getUserBorrowedBooks($email) {
    $conn = getConnection();
    $sql = "SELECT title, author, isbn, shelf, borrowed_date, return_date
            FROM borrowed_books
            WHERE status = 'borrowed' AND email = ?
            ORDER BY borrowed_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}



function countAllBorrowedBooks() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) as total FROM borrowed_books WHERE status = 'borrowed'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}


function getBorrowedBooksByUser($email) {
    $conn = getConnection();
    $sql = "SELECT bb.id, bb.book_id, b.title, b.author, b.isbn, b.shelf, bb.borrowed_date, bb.return_date
            FROM borrowed_books bb
            JOIN books b ON bb.book_id = b.id
            WHERE bb.status = 'borrowed' AND bb.email = ?
            ORDER BY bb.borrowed_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}


function markAsReturned($borrowId) {
    $conn = getConnection();
    $sql = "UPDATE borrowed_books SET status = 'returned' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $borrowId);
    return $stmt->execute();
}


function increaseBookQuantity($bookId) {
    $conn = getConnection();
    $sql = "UPDATE books SET quantity = quantity + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    return $stmt->execute();
}

function insertBorrowedBook($bookId, $borrowedDate, $returnDate, $email) {
    $conn = getConnection();

    
    $book = getBookById($bookId);
    if (!$book) return false;

    $sql = "INSERT INTO borrowed_books (book_id, title, author, isbn, shelf, borrowed_date, return_date, status, email)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'borrowed', ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssssss",
        $book['id'],
        $book['title'],
        $book['author'],
        $book['isbn'],
        $book['shelf'],
        $borrowedDate,
        $returnDate,
        $email
    );

    return $stmt->execute();
}


function getOverdueBooksByEmail($email) {
    $conn = getConnection();
    $sql = "SELECT bb.id, bb.book_id, b.title, b.author, b.isbn, b.shelf, bb.borrowed_date, bb.return_date
            FROM borrowed_books bb
            JOIN books b ON bb.book_id = b.id
            WHERE bb.email = ? 
              AND bb.status = 'borrowed' 
              AND DATEDIFF(NOW(), bb.borrowed_date) > 3";
              
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}
function countOverdueBooks($email) {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) as total FROM borrowed_books 
            WHERE email = ? 
              AND status = 'borrowed' 
              AND DATEDIFF(NOW(), borrowed_date) > 3";
              
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'];
}
function countBorrowedBooksByUser($email) {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) as total FROM borrowed_books 
            WHERE email = ? AND status = 'borrowed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'];
}
