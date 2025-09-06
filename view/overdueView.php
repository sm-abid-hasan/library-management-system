<?php
session_start();
require_once("../model/borrowModel.php");

if (!isset($_SESSION['email'])) {
    header("Location: loginView.php");
    exit();
}

$email = $_SESSION['email'];
$books = getOverdueBooksByEmail($email);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Overdue Returns</title>
    <link rel="stylesheet" href="../css/styleSearch.css">
</head>
<body>

<div class="result-container">
    <h2>Overdue Books</h2>

    <?php if ($books->num_rows === 0): ?>
        <p>No overdue books.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Title</th><th>Author</th><th>ISBN</th><th>Shelf</th>
                <th>Borrowed Date</th><th>Return Date</th><th>Action</th>
            </tr>
            <?php while ($row = $books->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['author']) ?></td>
                    <td><?= htmlspecialchars($row['isbn']) ?></td>
                    <td><?= htmlspecialchars($row['shelf']) ?></td>
                    <td><?= htmlspecialchars($row['borrowed_date']) ?></td>
                    <td><?= htmlspecialchars($row['return_date']) ?></td>
                    <td>
                        <form action="../controller/overdueController.php" method="POST">
                            <input type="hidden" name="borrow_id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                            <button type="submit">Return</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</div>

<?php if (isset($_SESSION['overdue_msg'])): ?>
    <div class="borrow-alert success">
        <p><?= $_SESSION['overdue_msg'] ?></p>
        <form action="home.php">
            <button type="submit">OK</button>
        </form>
    </div>
    <?php unset($_SESSION['overdue_msg']); ?>
<?php endif; ?>
echo "<br>"
    <a href="home.php">Back</a>
</body>
</html>
