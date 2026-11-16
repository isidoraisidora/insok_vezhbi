<?php
include '../database/db_connection.php';
include '../helpers/functions.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = connectDatabase();

    $a = $db->prepare("SELECT * FROM subscriptions where id = :id");
    $a->bindValue(':id', $id, SQLITE3_INTEGER);
    $ax = $a->execute()->fetchArray(SQLITE3_ASSOC);

    if(checkStatus($ax['date'], $ax['type']) === 'Active'){
        echo "You cannot delete an active subscription";
        $db->close();
        exit;
    }

    // Delete student by ID
    $stmt = $db->prepare("DELETE FROM subscriptions WHERE id = :id");
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