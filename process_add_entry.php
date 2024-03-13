<?php
require_once 'db.php';

// Create a new instance of the Database class
$database = new Database('Tables.db');

// Get the database connection
$db = $database->getDB();

echo '<a href="../project/index.php"><input type="button" value="Back to Dashboard"></a>';

// Check if the 'table' parameter is set in the URL
if (isset($_GET['table'])) {
    $tableName = $_GET['table'];

    // Check if the form is submitted and 'values' key exists in $_POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming you have sanitized user inputs for security
        $values = $_POST;

        // Exclude 'id' column as it is usually auto-incremented
        unset($values['id']);

        // Check if the array is not empty
        if (!empty($values)) {
            // Create a placeholder for the values in the SQL query
            $columns = implode(',', array_keys($values));
            $placeholders = implode(',', array_fill(0, count($values), '?'));

            // Prepare the SQL statement
            $stmt = $db->prepare("INSERT INTO $tableName ($columns) VALUES ($placeholders)");

            // Bind values to the prepared statement
            $index = 1;
            foreach ($values as $value) {
                $stmt->bindValue($index++, $value);
            }

            // Execute the statement
            if ($stmt->execute()) {
                // Entry added successfully
                header("Location: display_table.php?table=$tableName"); // Redirect to display table page
                exit();
            } else {
                // Error adding entry
                echo 'Error adding entry: ' . $db->lastErrorMsg();
            }
        } else {
            // Array 'values' is empty
            echo 'No values provided for the entry.';
        }
    } else {
        // Form not submitted
        echo 'Form not submitted.';
    }
} else {
    // 'table' parameter not specified
    echo 'Table parameter not specified.';
}

// Close the database connection
$database->closeDB();
?>
