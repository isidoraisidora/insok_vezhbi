<?php
include '../database/db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = connectDatabase();

    // Fetch the current details of the student
    $stmt = $db->prepare("SELECT * FROM subscriptions WHERE id = :id");
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
    <title>Update Subscription</title>
</head>
<body>
<h1>Update Subscription</h1>

<?php if ($student): ?>
    <form action="../handlers/update_handler.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br><br>
        <label for="type">Type:</label>
        <select name="type" id="type">
            <option <?php echo htmlspecialchars($student['type']==='Monthly' ? 'selected=true' : ''); ?> value="Monthly">Monthly</option>
            <option <?php echo htmlspecialchars($student['type'] === 'Yearly' ? 'selected=true' : ''); ?> value="Yearly">Yearly</option>
        </select>
        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($student['date']); ?>" required><br><br>
        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo htmlspecialchars($student['price']); ?>" required><br><br>
        <button type="submit">Update Student</button>
    </form>
<?php else: ?>
    <p>Student not found.</p>
<?php endif; ?>
</body>
</html>