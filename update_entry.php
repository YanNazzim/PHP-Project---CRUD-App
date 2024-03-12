<?php
require_once 'db.php';

// Create a new instance of the Database class
$database = new Database('Tables.db');

// Get the database connection
$db = $database->getDB();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the data from the form
    $tableName = $_POST['table'];
    $entryId = $_POST['id'];

    // Construct the update query based on form data
    $updateQuery = "UPDATE $tableName SET ";
    foreach ($_POST as $column => $value) {
        if ($column !== 'id' && $column !== 'table') {
            $updateQuery .= "$column = '$value', ";
        }
    }
    $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = $entryId";

    // Execute the update query
    $result = $db->exec($updateQuery);

    if ($result) {
        echo '<p>Entry updated successfully.</p>';
    } else {
        echo '<p>Error updating entry.</p>';
    }
} else {
    echo '<p>Form not submitted.</p>';
}

// Close the database connection
$database->closeDB();
?>
