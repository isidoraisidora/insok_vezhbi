<?php
include '../db_connection.php';

$db = connectDatabase();

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS expenses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    date TEXT NOT NULL,
    amount integer not null,
    type text not null
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table expenses created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();
?>