<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Books</title>
    <link rel="stylesheet" href="../css/styleSearch.css">
</head>
<body>
    <div class="top-bar">
        <div class="user-info">
            <span class="icon">👤</span>
            <span class="name">S M Abid Hasan</span><br>
            <span class="id">22-46789-1</span>
        </div>
    </div>

    <div class="center-content">
        <h1>Welcome To AIUB Library Management System</h1>
        <form action="../controller/searchController.php" method="POST" class="search-form">
            <input type="text" name="search" placeholder="Enter book name, author or ID" required>
            <button type="submit">Search</button>
        </form>
    </div>
</body>
</html>
