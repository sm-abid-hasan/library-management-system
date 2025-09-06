<?php
session_start();


if (!isset($_SESSION["search_results"]) || !isset($_SESSION["search_query"])) {
    header("Location: home.php");
    exit();
}

$results = $_SESSION["search_results"];
$query = $_SESSION["search_query"];
$message = $_SESSION["borrow_message"] ?? null;
unset($_SESSION["borrow_message"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/styleSearch.css">
</head>
<body>

    <?php if ($message): ?>
        <div class="borrow-alert <?= $message === 'Successfully done' ? 'success' : 'error' ?>">
            <p><?= htmlspecialchars($message) ?></p>
            <form action="home.php" method="get">
                <button type="submit">OK</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="result-container">
        <h2>Search Results for: "<?= htmlspecialchars($query) ?>"</h2>

        <?php if (empty($results)): ?>
            <p>No match found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Quantity</th>
                        <th>Shelf</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['isbn']) ?></td>
                            <td><?= htmlspecialchars($book['quantity']) ?></td>
                            <td><?= htmlspecialchars($book['shelf']) ?></td>
                            <td>
                                <form action="../controller/borrowController.php" method="POST">
                                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                    <input type="hidden" name="quantity" value="<?= $book['quantity'] ?>">
                                    <button type="submit" <?= $book['quantity'] = 0 ? 'disabled' : '' ?>>
                                        Borrow
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    echo "<br>"
    <a href="home.php">Back</a>

</body>
</html>
