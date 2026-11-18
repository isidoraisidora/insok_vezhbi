<?php
// Include the database connection file
include 'database/db_connection.php';
session_start();
require 'jwt_helper.php';

// Проверка дали JWT токенот постои и е валиден
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: pages/auth/login.php");
    exit;
}

// Connect to the SQLite database
$db = connectDatabase();

// Fetch all students from the database
$query = "SELECT * FROM expenses";
$result = $db->query($query);

if (!$result) {
    die("Error fetching students: " . $db->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Expenses</title>
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
    <h1>Expenses List</h1>
    <a href="pages/create.php">
        Add Expense
    </a>
    <a href="handlers/auth/logout_handler.php">
        Logout
    </a>
</div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result): ?>
        <?php while ($student = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($student['id']); ?></td>
                <td><?php echo htmlspecialchars($student['name']); ?></td>
                <td><?php echo htmlspecialchars($student['date']); ?></td>
                <td><?php echo htmlspecialchars($student['amount']); ?></td>
                <td><?php echo htmlspecialchars($student['type']); ?></td>
                <td>
                    <form action="handlers/delete_handler.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form action="pages/update.php" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                        <button type="submit">Update</button>
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
</body>
</html>