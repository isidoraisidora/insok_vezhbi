<?php
include '../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = connectDatabase();

    $query = $db->prepare('select * from repairs where id = :id');
    $query->bindValue(':id', $id, SQLITE3_INTEGER);
    $a = $query->execute()->fetchArray(SQLITE3_ASSOC);

    if($a['status'] === 'In progress'){
        echo "Cannot delete a repairs that is in progress";
        $db->close();
        exit;
    }

    // Delete student by ID
    $stmt = $db->prepare("DELETE FROM repairs WHERE id = :id");
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