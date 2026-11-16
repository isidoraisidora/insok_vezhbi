<?php
include '../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name_owner = $_POST['name_owner'];
    $name_pet = $_POST['name_pet'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $price = (int) ($_POST['price']);

    $db = connectDatabase();

    // Update student details
    $stmt = $db->prepare("UPDATE examinations SET name_owner = :name_owner, name_pet = :name_pet, date = :date, status = :status, price = :price WHERE id = :id");
    $stmt->bindValue(':name_owner', $name_owner, SQLITE3_TEXT);
    $stmt->bindValue(':name_pet', $name_pet, SQLITE3_TEXT);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':status', $status, SQLITE3_TEXT);
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