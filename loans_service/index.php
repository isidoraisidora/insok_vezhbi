<?php
// Include the database connection file

session_start();
require 'jwt_helper.php';

// Проверка дали JWT токенот постои и е валиден
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: pages/auth/login.php");
    exit;
}
include 'database/db_connection.php';
include 'helpers/functions.php';
// Connect to the SQLite database
$db = connectDatabase();

// Fetch all students from the database
$username = $_SESSION['username'];

$query = $db->prepare("SELECT l.id as ID, l.date_loan, l.date_return, b.title, l.number_days FROM loans l join books b on l.book_id=b.id join users u on l.user_id=u.id where u.username = :username");
$query->bindValue(':username', $username, SQLITE3_TEXT);
$result = $query->execute();


if (!$result) {
    die("Error fetching students: " . $db->lastErrorMsg());
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
<div style="display: flex; align-items: center; justify-content: space-between">
    <h1>Loans List</h1>
    <a href="pages/create.php">
        Add Loan
    </a>
    <a href="handlers/auth/logout_handler.php">
        Logout
    </a>
</div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Book Title</th>
        <th>Date rent</th>
        <th>Date return</th>
        <th>Fee</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result): ?>
        <?php while ($student = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($student['ID']); ?></td>
                <td><?php echo htmlspecialchars($student['title']); ?></td>
                <td><?php echo htmlspecialchars($student['date_loan']); ?></td>
                <td><?php echo htmlspecialchars($student['date_return']); ?></td>
                <td><?php echo calculateFee($student['date_loan'], $student['date_return'], $student['number_days']); ?></td>
                <td><?php echo checkStatus($student['date_loan'], $student['date_return'], $student['number_days']); ?></td>
                <td>
                    <form action="handlers/delete_handler.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $student['ID']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form action="handlers/return_handler.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $student['ID']; ?>">
                        <button type="submit">Return</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No students found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<p>Total sum of all fees:
<?php
$total = 0;
while ($student = $result->fetchArray(SQLITE3_ASSOC)){
    $total += calculateFee($student['date_loan'], $student['date_return'], $student['number_days']);
}
echo $total;
?>MKD.


</p>
</body>
</html>