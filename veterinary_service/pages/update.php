<?php
include '../database/db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = connectDatabase();

    // Fetch the current details of the student
    $stmt = $db->prepare("SELECT * FROM examinations WHERE id = :id");
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
    <title>Update Student</title>
</head>
<body>
<h1>Update Student</h1>

<?php if ($student): ?>
    <form action="../handlers/update_handler.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
        <label for="name_owner">Name owner:</label>
        <input type="text" name="name_owner" value="<?php echo htmlspecialchars($student['name_owner']); ?>" required><br><br>
        <label for="name_pet">Name pet:</label>
        <input type="text" name="name_pet" value="<?php echo htmlspecialchars($student['name_pet']); ?>" required><br><br>
        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($student['date']); ?>" required><br><br>
        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo htmlspecialchars($student['price']); ?>" required><br><br>
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option <?php echo htmlspecialchars($student['status']) === 'Scheduled' ? 'selected=true' : ''; ?> value="Scheduled">Scheduled</option>
            <option <?php echo htmlspecialchars($student['status']) === 'In treatment' ? 'selected=true' : ''; ?> value="In treatment">In treatment</option>
            <option <?php echo htmlspecialchars($student['status']) === 'Completed' ? 'selected=true' : ''; ?> value="Completed">Completed</option>
        </select>
        <button type="submit">Update Student</button>
    </form>
<?php else: ?>
    <p>Student not found.</p>
<?php endif; ?>
</body>
</html>