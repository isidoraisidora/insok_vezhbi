<?php
// Започнување на сесија за чување на податоци за сесијата
session_start();

// Вчитување на потребните фајлови за база на податоци и JWT помошни функции
require '../../database/db_connection.php';  // Вчитување на поврзувањето со базата
require '../../jwt_helper.php';  // Вчитување на функциите за работа со JWT токени


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPass = $_POST['password_confirm'];

    if($password !== $confirmPass){
        echo "The passwords don't match";
        exit;
    }

    $db = connectDatabase();

    $stmt = $db->prepare("SELECT * FROM users where username = :username");
    $stmt->bindValue(":username", $username);
    $res = $stmt->execute();
    $user = $res->fetchArray(SQLITE3_ASSOC);


    // Проверка дали корисникот постои и дали лозинката е валидна
    if ($user && password_verify($password, $user['password'])) {
        // Ако корисникот и лозинката се точни, креирање на JWT токен
        $token = createJWT($user['id'], $user['username']);

        // Регенирање на сесијата за да се избегнат напади со фиксација на сесијата
        session_regenerate_id(true);

        // Чување на JWT токенот во сесијата
        $_SESSION['username'] = $username;
        $_SESSION['jwt'] = $token;


        // Пренасочување на корисникот на главната страна
        header('Location: ../../index.php');
        exit;  // Завршување на скриптата за да не се извршуваат понатамошни редови код
    } else {
        // Ако најавата не е успешна, следи зголемување на бројот на обиди

        // Ако корисничкото име или лозинката не се точни, прикажување на порака за грешка
        echo "Корисничкото име или лозинката се невалидни.<br>";
        echo "<a href='../../pages/auth/login.php'><button>Обидете се повторно</button></a>";
        exit;
    }
}
?>