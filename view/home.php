<?php
session_start();
require_once("../model/usersModel.php");
require_once("../model/borrowModel.php");

if (!isset($_SESSION["username"]) || !isset($_SESSION["email"])) {
    header("Location: loginView.php");
    exit();
}

$email = $_SESSION["email"];
$user = getUserByEmail($email);


$borrowedCount = countBorrowedBooksByUser($email);

$overdueCount = countOverdueBooks($email);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="../css/style1home.css">
    <link rel="stylesheet" href="../css/card.css"> 
</head>
<body>

    
    <div class="user-top">
        <span class="user-icon">👤</span>
        <span class="user-name">
            <?php echo htmlspecialchars($user['name']); ?><br>
            <?php echo htmlspecialchars($user['email']); ?>
        </span>
    </div>

    
    <div id="form_container">
        <h1>Welcome to AIUB <br> Library Management System</h1>

        
        <form action="../controller/searchController.php" method="POST" class="search-form">
            <input type="text" name="search" placeholder="Enter book name or ISBN" required>
            <button type="submit">Search</button>
        </form>

        
        <div class="card-wrapper">
            <a href="borrowedBooks.php" class="card-link">
                <div class="card-box">
                    <h3>Borrowed Books</h3>
                    <p class="card-count"><?= $borrowedCount ?></p>
                </div>
            </a>
        </div>



<div class="card-wrapper1">
    <a href="returnView.php" class="card-link">
        <div class="card-box">
            <h3>Return Books</h3>
            <p class="card-count">🔁</p>
        </div>
    </a>
</div>

<div class="card-wrapper2">
    <a href="overdueView.php" class="card-link">
        <div class="card-box">
            <h3>Overdue Returns</h3>
            <p class="card-count"><?= $overdueCount ?></p>
        </div>
    </a>
</div>
<div class="user-right">
<a href="../controller/logoutController.php">Logout</a>
</div>
</div>
</body>
</html>
