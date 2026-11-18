<?php

include '../db_connection.php';

$db = connectDatabase();

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username unique not null,
    password not null,
    role text
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table users created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();
