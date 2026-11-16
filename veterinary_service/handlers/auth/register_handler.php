<?php
// Започнување на сесија за чување на податоци за сесијата
session_start();

// Вчитување на поврзувањето со базата на податоци
require '../../database/db_connection.php';

// Проверка дали формата е испратена преку POST метода
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Преземање на податоци од формата за корисничко име и лозинка
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Проверка за минимална должина на корисничко име и лозинка
    if (strlen($username) < 3 || strlen($password) < 6) {
        die('Корисничкото име мора да има најмалку 3 карактери, а лозинката најмалку 6.');
    }

    // Хеширање на лозинката за безбедност
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Вметнување на нов корисник во базата на податоци

    $db = connectDatabase();
    $stmt = $db->prepare("insert into users (username, password) values (:username, :password)");
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":password", $hashedPassword);

    if($stmt->execute()){
        header("Location: ../../pages/auth/login.php");
        $db->close();
    }
    else{
        echo "Error adding student: " . $db->lastErrorMsg();
    }

}
else {
    // If not a POST request, display an error message
    echo "Invalid request method. Please submit the form to add a student.";
}
?>
?>