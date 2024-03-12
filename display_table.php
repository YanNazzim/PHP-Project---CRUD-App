<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Table Details</title>
</head>

<body>


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

        // Add an "Add" button above the table
        echo '<button id="addButton">Add</button>';

        // Fetch all rows from the specified table
        $result = $db->query("SELECT * FROM $tableName");

        // Check if there are rows in the result
        if ($result) {
            echo '<h2>Table: ' . $tableName . '</h2>';
            echo '<table border="1" style="width: 98vw; max-width: 98vw;">';

            // Output table header
            echo '<tr>';
            for ($i = 0; $i < $result->numColumns(); $i++) {
                echo '<th style="font-size: 16pt; padding: 10px; border: 3px solid black;">' . $result->columnName($i) . '</th>';
            }
            // Add an additional column for actions
            echo '<th style="border: 3px solid black; font-size: 16pt; font-weight: bolder;">Actions</th>';
            echo '</tr>';

            // Output table rows
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                echo '<tr>';
                foreach ($row as $value) {
                    echo '<td style="font-size: 14pt; padding: 10px; text-align: center; border: 3px solid black; font-weight: bolder;">' . $value . '</td>';
                }

                // Check if 'id' key exists in the $row array
                $idColumnExists = isset($row['id']);

                // Add edit and delete buttons for each row
                echo '<td <td style="font-size: 14pt; padding: 10px; text-align: center; border: 3px solid black; font-weight: bolder;">';

                // Check if 'id' key exists before creating the Edit button
                if ($idColumnExists) {
                    $editUrl = "edit_entry.php?table=$tableName&id=" . $row['id'];
                    echo '<a href="' . $editUrl . '"><button>Edit</button></a>';
                }

                // Add delete button for each row
                $deleteUrl = "delete_entry.php?table=$tableName&id=" . $row['id'];
                echo '<button class="delete-btn" onclick="confirmDelete(\'' . $deleteUrl . '\')">Delete</button>';

                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No records found in the table.</p>';
            echo '<p>Error: ' . $db->lastErrorMsg() . '</p>';
        }
    } else {
        echo '<p>Table parameter not specified.</p>';
    }

    // Close the database connection
    $database->closeDB();
    ?>

    <script>
        function confirmDelete(deleteUrl) {
            var confirmDelete = confirm("Are you sure you want to delete this entry?");
            if (confirmDelete) {
                window.location.href = deleteUrl;
            }
        }
    </script>

</body>

</html>