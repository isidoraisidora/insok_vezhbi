<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add repair</title>
</head>
<body>
<form action="../handlers/create_handler.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" >
    <br />
    <label for="model">Model:</label>
    <input type="text" name="model" id="model" >
    <br />
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" >
    <br />
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" >
    <br />
    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="Received">Received</option>
        <option value="In progress">In progress</option>
        <option value="Done">Done</option>
    </select>
    <br />
    <button type="submit">Add Repair</button>
</form>
</body>