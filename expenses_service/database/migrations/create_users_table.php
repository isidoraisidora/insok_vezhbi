<?php
include '../db_connection.php';

$db = connectDatabase();

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT unique NOT NULL,
    password TEXT NOT NULL,
    role text not null
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table users created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();
?>