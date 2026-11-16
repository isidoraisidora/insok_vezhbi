<?php

include '../db_connection.php';

$db = connectDatabase();

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS examinations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name_owner text not null,
    name_pet text not null,
    date text not null,
    price integer not null,
    status text not null
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table examinations created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();
?>