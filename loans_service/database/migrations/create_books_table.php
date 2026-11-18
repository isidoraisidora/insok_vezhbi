<?php

include '../db_connection.php';

$db = connectDatabase();

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title text not null,
    author text not null
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}


$count = $db->querySingle("SELECT COUNT(*) FROM books");

if ($count == 0) {
    $db->exec("INSERT INTO books (title, author) VALUES ('title1', 'author1')");
    $db->exec("INSERT INTO books (title, author) VALUES ('title2', 'author2')");
    $db->exec("INSERT INTO books (title, author) VALUES ('title3', 'author3')");
    $db->exec("INSERT INTO books (title, author) VALUES ('title4', 'author4')");
    $db->exec("INSERT INTO books (title, author) VALUES ('title5', 'author5')");
    echo "Successfully added books.";
} else {
    echo "Books already exist, nothing added.";
}


$db->close();
?>