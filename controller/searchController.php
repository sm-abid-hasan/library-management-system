<?php
session_start();
require_once("../model/bookModel.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchText = trim($_POST["search"]);
    $result = searchBooks($searchText);

    
    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    $_SESSION["search_results"] = $books;
    $_SESSION["search_query"] = $searchText;

    header("Location: ../view/searchResult.php");
    exit();
}

