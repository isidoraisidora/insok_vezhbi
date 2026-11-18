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
$query = "SELECT * FROM repairs order by date desc";
$result = $db->query($query);

if (!$result) {
    die("Error fetching students: " . $db->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Repairs</title>
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
    <h1>Repairs List</h1>
    <a href="pages/create.php">
        Add Repair
    </a>
    <a href="handlers/auth/logout.php">
        Logout
    </a>
    <span>
        Welcome <?php echo $_SESSION['username']; ?>
    </span>
</div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name of Client</th>
        <th>Model</th>
        <th>Date of acceptance</th>
        <th>Price</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result): ?>
        <?php while ($student = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($student['id']); ?></td>
                <td><?php echo htmlspecialchars($student['name']); ?></td>
                <td><?php echo htmlspecialchars($student['model']); ?></td>
                <td><?php echo htmlspecialchars($student['date']); ?></td>
                <td><?php echo htmlspecialchars($student['price']); ?></td>
                <td><?php echo htmlspecialchars($student['status']); ?></td>

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

<p>Total earnings from completed repairs:
<?php
$total = 0;
while ($student = $result->fetchArray(SQLITE3_ASSOC)){
    if($student['status'] === 'Done')
        $total += $student['price'];
}
echo $total;
?>
MKD
</p>
</body>
</html>