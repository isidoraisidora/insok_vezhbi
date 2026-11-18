<?php

include '../database/db_connection.php';
// Connect to the SQLite database
$db = connectDatabase();

// Fetch all students from the database
$query = "SELECT * FROM books";
$result = $db->query($query);

if (!$result) {
    die("Error fetching students: " . $db->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Loan</title>
</head>
<body>
<form action="../handlers/create_handler.php" method="POST">
    <label for="book_id">Book:</label>
    <select name="book_id" id="book_id">
        <?php while ($student = $result->fetchArray(SQLITE3_ASSOC)):?>
        <option value="<?php echo $student['id']; ?>"><?php echo $student['title'] ?></option>
        <script>console.log(<?php echo $student['id'] ?>)</script>
        <?php endwhile; ?>
    </select><br/>
    <label for="date_loan">Date of loan:</label>
    <input type="date" name="date_loan" id="date_loan" required>
    <br />
    <label for="number_days">Number of days for rent:</label>
    <select name="number_days" id="number_days">
        <option value=7>7</option>
        <option value=14>14</option>
        <option value=30>30</option>
    </select>
    <br />
    <button type="submit">Add Loan</button>
</form>
</body>