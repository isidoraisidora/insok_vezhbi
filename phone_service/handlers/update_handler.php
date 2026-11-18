<?php
include '../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $model = $_POST['model'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $price = (int) ($_POST['price']);

    $db = connectDatabase();

    // Update student details
    $stmt = $db->prepare("UPDATE repairs SET name = :name, model = :model, date = :date, price = :price, status = :status WHERE id = :id");
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':model', $model, SQLITE3_TEXT);
    $stmt->bindValue(':status', $status,SQLITE3_TEXT);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':price', $price, SQLITE3_INTEGER);
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