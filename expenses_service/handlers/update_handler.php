<?php
include '../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $date = $_POST['date'];
    $type = $_POST['type'];
    $amount = (int) ($_POST['amount']);

    $db = connectDatabase();

    // Update student details
    $stmt = $db->prepare("UPDATE expenses SET name = :name, date = :date, amount = :amount, type = :type WHERE id = :id");
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':type', $type, SQLITE3_TEXT);

    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':amount', $amount, SQLITE3_INTEGER);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();

    // Close the database connection
    $db->close();

    // Redirect back to the view page
    header("Location: ../index.php");
    exit();
} else {
    echo "Invalid request.";
}
?>