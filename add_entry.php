<!-- add_entry.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Entry</title>
</head>

<body>
    <?php
    require_once 'db.php';

    // Create a new instance of the Database class
    $database = new Database('Tables.db');

    // Get the database connection
    $db = $database->getDB();

    // Back to Dashboard Button
    echo '<a href="../project/index.php"><input type="button" value="Back to Dashboard"></a>';

    // Check if the 'table' parameter is set in the URL
    if (isset($_GET['table'])) {
        $tableName = $_GET['table'];

        // Fetch table headers and data types
        $result = $db->query("PRAGMA table_info($tableName)");

        // Check if there are columns in the table
        if ($result) {
            echo '<h2>Add Entry to ' . $tableName . '</h2>';
            echo '<form method="post" action="process_add_entry.php?table=' . $tableName . '">';
            echo '<table border="1">';

            // Output form fields based on table headers
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $columnName = $row['name'];
                $dataType = $row['type'];

                // Exclude 'id' column as it is usually auto-incremented
                if ($columnName !== 'id') {
                    echo '<tr>';
                    echo '<td>' . $columnName . '</td>';
                    
                    // Check if the column is 'last_edited' and set its value to the current timestamp
                    if ($columnName === 'last_edited') {
                        echo '<td><input type="text" name="' . $columnName . '" value="' . date("m/d/Y h:i A") . '" readonly></td>';
                    } else {
                        echo '<td><input type="' . getInputType($dataType) . '" name="' . $columnName . '" required></td>';
                    }
                    
                    echo '</tr>';
                }
            }

            echo '</table>';
            echo '<input type="submit" value="Add Entry">';
            echo '</form>';
        } else {
            echo '<p>No columns found in the table.</p>';
        }
    } else {
        echo '<p>Table parameter not specified.</p>';
    }

    // Close the database connection
    $database->closeDB();

    // Function to determine HTML input type based on SQLite data type
    function getInputType($dataType)
    {
        // Customize this function based on your data types and form requirements
        switch ($dataType) {
            case 'INTEGER':
                return 'number';
            case 'TEXT':
                return 'text';
            case 'REAL':
                return 'number';
            default:
                return 'text';
        }
    }
    ?>

</body>

</html>
