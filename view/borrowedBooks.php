<?php
session_start();
require_once("../model/borrowModel.php");


if (!isset($_SESSION["email"])) {
    header("Location: loginView.php");
    exit();
}


$email = $_SESSION["email"];


$borrowedBooks = getUserBorrowedBooks($email);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Borrowed Books</title>
    <link rel="stylesheet" href="../css/styleSearch.css">
</head>
<body>
    <div class="result-container">
        <h2>Your Borrowed Books</h2>

        <?php if ($borrowedBooks->num_rows === 0): ?>
            <p>You haven't borrowed any books yet.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Shelf</th>
                        <th>Borrowed Date</th>
                        <th>Return Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $borrowedBooks->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['author']) ?></td>
                            <td><?= htmlspecialchars($row['isbn']) ?></td>
                            <td><?= htmlspecialchars($row['shelf']) ?></td>
                            <td><?= htmlspecialchars($row['borrowed_date']) ?></td>
                            <td><?= htmlspecialchars($row['return_date']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <br>
        <a href="home.php">Back</a>
    </div>
</body>
</html>
