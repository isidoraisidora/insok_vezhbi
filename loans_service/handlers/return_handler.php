<?php

session_start();
// Include the database connection file
include '../database/db_connection.php';

// Check if the request method is POST to handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values from the POST request, with basic validation
    $id = (int) ($_POST['id']);
    if ($id <= 0){
        echo "Invalid id";
        exit;
    }

    $date_return = new DateTime('now');
    $date_return = $date_return->format('Y-m-d');


    // Connect to the SQLite database
    $db = connectDatabase();

    $query = $db->prepare("UPDATE loans SET date_return = :date_return WHERE id = :id");
    $query->bindValue(':id', $id, SQLITE3_INTEGER);
    $query->bindValue(':date_return', $date_return);


    // Execute the statement and check for success
    if ($query->execute()) {
        // Redirect back to the view page
        header("Location: ../../index.php");
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