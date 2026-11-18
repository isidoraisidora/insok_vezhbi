<?php

include '../db_connection.php';

$db = connectDatabase();

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS repairs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    model TEXT NOT NULL,
    date text not null,
    price INTEGER NOT NULL,
    status text not null
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table repairs created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();
