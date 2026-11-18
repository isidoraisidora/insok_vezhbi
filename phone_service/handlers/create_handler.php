<?php
// Include the database connection file
include '../database/db_connection.php';

// Check if the request method is POST to handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values from the POST request, with basic validation
    $name = $_POST['name'] ?? '';
    $model = $_POST['model'] ?? '';
    $date = $_POST['date'] ?? '';
    $status = $_POST['status'] ?? '';
    $price = (int) ($_POST['price'] ?? 0);

    // Validate required fields
    if (empty($name) || empty($model) || $price <= 0 || empty($date) || ($status !== 'Received' && $status !== 'In progress' && $status !== 'Done')) {
        echo "Please fill in all required fields correctly.";
        exit;
    }

    // Connect to the SQLite database
    $db = connectDatabase();

    // Prepare and execute the insert statement
    $stmt = $db->prepare("INSERT INTO repairs (name, model, date, price, status) VALUES (:name, :model, :date, :price, :status)");
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':model', $model, SQLITE3_TEXT);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':status', $status, SQLITE3_TEXT);
    $stmt->bindValue(':price', $price, SQLITE3_INTEGER);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect back to the view page
        header("Location: ../index.php");
    } else {
        echo "Error adding student: " . $db->lastErrorMsg();
    }

    // Close the database connection
    $db->close();
} else {
    // If not a POST request, display an error message
    echo "Invalid request method. Please submit the form to add a student.";
}
?>