<?php
session_start();
require_once("../model/borrowModel.php"); 


if (!isset($_SESSION["email"])) {
    header("Location: loginView.php");
    exit();
}

$email = $_SESSION["email"];
$borrowedBooks = getBorrowedBooksByUser($email);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Borrowed Books</title>
    <link rel="stylesheet" href="../css/styleSearch.css">
</head>
<body>

<?php if (isset($_SESSION["return_message"])): ?>
    <div class="borrow-alert <?= $_SESSION["return_message"] === 'Successfully done' ? 'success' : 'error' ?>">
        <p><?= htmlspecialchars($_SESSION["return_message"]) ?></p>
        <form action="home.php" method="get">
            <button type="submit">OK</button>
        </form>
    </div>
    <?php unset($_SESSION["return_message"]); ?>
<?php endif; ?>

<div class="result-container">
    <h2>Return Borrowed Books</h2>

    <?php if ($borrowedBooks->num_rows === 0): ?>
        <p>No borrowed books.</p>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $borrowedBooks->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['author']) ?></td>
                        <td><?= htmlspecialchars($row['isbn']) ?></td>
                        <td><?= htmlspecialchars($row['shelf']) ?></td>
                        <td><?= htmlspecialchars($row['borrowed_date']) ?></td>
                        <td><?= htmlspecialchars($row['return_date']) ?></td>
                        <td>
                            <form action="../controller/returnController.php" method="POST">
                                <input type="hidden" name="borrow_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                                <button type="submit">Return</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
echo "<br>"
    <a href="home.php">Back</a>

</body>
</html>
