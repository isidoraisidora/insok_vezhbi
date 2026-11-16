<?php
include '../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = connectDatabase();

    $a = $db->prepare("select * from examinations where id = :id");
    $a->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $a->execute()->fetchArray(SQLITE3_ASSOC);

    if($result['status'] == 'In treatment'){
        echo 'Cannot delete, the examination is in treatment';
        $db->close();
        exit;
    }

    // Delete student by ID
    $stmt = $db->prepare("DELETE FROM examinations WHERE id = :id");
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