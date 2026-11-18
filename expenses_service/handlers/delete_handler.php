<?php
include '../database/db_connection.php';

session_start();
require '../jwt_helper.php';

// Проверка дали JWT токенот постои и е валиден
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = connectDatabase();

    $query = $db->prepare('select * from expenses where id = :id');
    $query->bindValue(':id', $id, SQLITE3_INTEGER);
    $a = $query->execute()->fetchArray(SQLITE3_ASSOC);

    if($a['amount'] > 100){
        echo "Cannot delete expense with amount larger than 100";
        $db->close();
        exit;
    }

    // Delete student by ID
    $stmt = $db->prepare("DELETE FROM expenses WHERE id = :id");
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