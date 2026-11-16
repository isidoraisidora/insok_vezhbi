<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add examination</title>
</head>
<body>
<form action="../handlers/create_handler.php" method="POST">
    <label for="name_owner">Name owner:</label>
    <input type="text" name="name_owner" id="name_owner" required>
    <br />
    <label for="name_pet">Name pet:</label>
    <input type="text" name="name_pet" id="name_pet" required>
    <br />
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <br />
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" required>
    <br />
    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="Scheduled">Scheduled</option>
        <option value="In treatment">In treatment</option>
        <option value="Completed">Completed</option>

    </select>
    <button type="submit">Add Examination</button>
</form>
</body>