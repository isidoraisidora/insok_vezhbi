<?php
include '../database/db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = connectDatabase();

    // Fetch the current details of the student
    $stmt = $db->prepare("SELECT * FROM repairs WHERE id = :id");
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
    <title>Update Repair</title>
</head>
<body>
<h1>Update Repair</h1>

<?php if ($student): ?>
    <form action="../handlers/update_handler.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br><br>
        <label for="model">Model:</label>
        <input id="model" type="text" name="model" value="<?php echo htmlspecialchars($student['model']); ?>" required><br><br>
        <label for="date">Date:</label>
        <input id="date" type="date" name="date" value="<?php echo htmlspecialchars($student['date']); ?>" required><br><br>
        <label for="price">Price:</label>
        <input id="price" type="number" name="price" value="<?php echo htmlspecialchars($student['price']); ?>" required><br><br>
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option <?php echo htmlspecialchars($student['status']) === 'In progress' ? 'selected=true': ''; ?> value="In progress" >In progress</option>
            <option <?php echo htmlspecialchars($student['status']) === 'Received' ? 'selected=true': ''; ?> value="Received">Received</option>
            <option <?php echo htmlspecialchars($student['status']) === 'Done' ? 'selected=true': ''; ?> value="Done">Done</option>


        </select><br/>

        <button type="submit">Update Student</button>
    </form>
<?php else: ?>
    <p>Student not found.</p>
<?php endif; ?>
</body>
</html>