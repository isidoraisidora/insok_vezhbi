<?php
include '../database/db_connection.php';

session_start();
require '../jwt_helper.php';

// Проверка дали JWT токенот постои и е валиден
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: auth/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = connectDatabase();

    // Fetch the current details of the student
    $stmt = $db->prepare("SELECT * FROM expenses WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $student = $result->fetchArray(SQLITE3_ASSOC);

    $db->close();
} else {
    die("Invalid student ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Expense</title>
</head>
<body>
<h1>Update Expense</h1>

<?php if ($student): ?>
    <form action="../handlers/update_handler.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br><br>
        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($student['date']); ?>" required><br><br>
        <label for="amount">Amount:</label>
        <input type="number" name="amount" value="<?php echo htmlspecialchars($student['amount']); ?>" required><br><br>
        <label for="type">Type:</label>
        <select name="type" id="type">
            <option <?php echo htmlspecialchars($student['type']) === 'Cash' ? 'selected=true' : ''; ?> value="Cash">Cash</option>
            <option <?php echo htmlspecialchars($student['type']) === 'Card' ? 'selected=true' : ''; ?> value="Card">Card</option>

        </select><br/>

        <button type="submit">Update Expense</button>
    </form>
<?php else: ?>
    <p>Student not found.</p>
<?php endif; ?>
</body>
</html>