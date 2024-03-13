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
        if ($column !== 'id' && $column !== 'table' && $column !== 'last_edited') {
            $updateQuery .= "$column = '$value', ";
        }
    }
    $updateQuery .= "last_edited = CURRENT_TIMESTAMP ";
    $updateQuery .= "WHERE id = $entryId";
    // Execute the update query
    $result = $db->exec($updateQuery);

    // Check if the entry was updated successfully
    if ($result) {
        echo '<script>';
        echo 'alert("Entry updated successfully.");';
        echo 'window.location.href = "display_table.php?table=' . $tableName . '";';
        echo '</script>';
        exit();
    } else {
        echo '<script>';
        echo 'alert("Error updating entry.");';
        echo 'window.location.href = document.referrer;';
        echo '</script>';
        exit();
    }
} else {
    echo '<p>Form not submitted.</p>';
}

// Close the database connection
$database->closeDB();
