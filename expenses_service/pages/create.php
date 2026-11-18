<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Expense</title>
</head>
<body>
<form action="../handlers/create_handler.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" >
    <br />
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" >
    <br />
    <label for="amount">Amount:</label>
    <input type="number" name="amount" id="amount" >
    <br />
    <label for="type">Type:</label>
    <select name="type" id="type">
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
    </select><br/>

    <button type="submit">Add Expense</button>
</form>
</body>