<?php

include '../db_connection.php';

$db = connectDatabase();

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS loans (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    book_id integer not null,
    user_id integer not null,
    date_loan text not null,
    number_days integer not null,
    date_return text,
    foreign key (book_id) references books(id) on delete cascade,
    foreign key (user_id) references users(id) on delete cascade
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table loans created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}