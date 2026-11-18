<?php

session_start();
// Include the database connection file
include '../database/db_connection.php';

// Check if the request method is POST to handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values from the POST request, with basic validation
    $book_id = (int) ($_POST['book_id']);
    $date_loan = $_POST['date_loan'] ?? '';
    $number_days = (int) ($_POST['number_days'] ?? 0);
    $date_return = $_POST['date_return'] ?? 'null';

    // Validate required fields
    if (empty($date_loan) || $book_id < 0 || $number_days == 0) {
        echo "Please fill in all required fields correctly.";
        echo $date_loan. " ". $book_id. " ". $number_days;
        exit;
    }

    // Connect to the SQLite database
    $db = connectDatabase();

    /*$date = new DateTime($date_loan);
    if($number_days == 7) $date_return = $date->modify('+7 days');
    else if($number_days == 14) $date_return = $date->modify('+14 days');
    else $date_return = $date->modify('+30 days');

    $date_return = $date_return->format('Y-m-d');*/



    $user_id = $_SESSION['user_id'];

    // Prepare and execute the insert statement
    $stmt = $db->prepare("INSERT INTO loans (book_id, user_id, date_loan, number_days, date_return) VALUES (:book_id, :user_id, :date_loan, :number_days, :date_return)");
    $stmt->bindValue(':book_id', $book_id, SQLITE3_INTEGER);
    $stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
    $stmt->bindValue(':date_loan', $date_loan);
    $stmt->bindValue(':number_days', $number_days, SQLITE3_INTEGER);
    $stmt->bindValue(':date_return', $date_return);


    // Execute the statement and check for success
    if ($stmt->execute()) {
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