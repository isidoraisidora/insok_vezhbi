<?php
include '../database/db_connection.php';
include '../helpers/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = connectDatabase();

    $query = $db->prepare('select * from loans where id = :id');
    $query->bindValue(':id', $id, SQLITE3_INTEGER);
    $a = $query->execute()->fetchArray(SQLITE3_ASSOC);

    if(checkStatus($a['date_loan'], $a['date_return'], $a['number_days']) === 'Active'){
        echo 'Cannot delete an active loan';
        $db->close();
        exit;
    }

    // Delete student by ID
    $stmt = $db->prepare("DELETE FROM loans WHERE id = :id");
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