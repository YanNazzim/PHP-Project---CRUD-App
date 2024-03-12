<?php
require_once 'db.php';

// Create a new instance of the Database class
$database = new Database('Tables.db');

// Get the database connection
$db = $database->getDB();
?>

<html>
<head>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1 id="dashHeading">Dashboard</h1>

    <?php
    // Fetch the table names from the database
    $result = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name != 'sqlite_sequence' ORDER BY name ASC");

    // Check if there are tables
    if ($result->numColumns() > 0) {
        echo '<ul>';
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // Use urlencode to handle table names with special characters
            $tableName = urlencode($row['name']);
            $capitalizedName = strtoupper($row['name']); // Convert to uppercase
            echo '<li id="tableName"><a href="display_table.php?table=' . $tableName . '">' . $capitalizedName . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo 'No tables found.';
    }
    ?>

</body>

<footer>

</footer>
</html>
