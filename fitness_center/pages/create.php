<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Subscription</title>
</head>
<body>
<form action="../handlers/create_handler.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <br />
    <label for="type">Type:</label>
    <select name="type" id="type">
        <option value="Monthly">Monthly</option>
        <option value="Yearly">Yearly</option>
    </select>
    <br />
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <br />
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" required>
    <br />
    <button type="submit">Add Student</button>
</form>
</body>