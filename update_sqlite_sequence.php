<?php
// update_sqlite_sequence.php

// Include your database connection file
require_once 'db.php';

// Get the database connection
$database = new Database('Tables.db');
$db = $database->getDB();

// Check if the 'table' parameter is set
if (isset($_GET['table'])) {
    $tableName = $_GET['table'];

    // Update sqlite_sequence for the specified table
    $db->exec("DELETE FROM sqlite_sequence WHERE name = '$tableName'");
}

// Close the database connection
$database->closeDB();
?>
