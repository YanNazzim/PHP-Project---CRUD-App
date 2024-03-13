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

    // Back to Dashboard Button
    echo '<a href="../project/index.php"><input type="button" value="Back to Dashboard"></a>';

    // Check if the 'table' parameter is set in the URL
    if (isset($_GET['table'])) {
        $tableName = $_GET['table'];

        // Add an "Add" button above the table
        echo '<button id="addButton" onclick="openAddForm()">Add</button>';

        // Fetch all rows from the specified table
        $result = $db->query("SELECT * FROM $tableName");

        // Check if there are rows in the result
        if ($result) {
            echo '<h2>Table: ' . $tableName . '</h2>';
            echo '<table border="1" style="width: 98vw; max-width: 98vw;">';

            // Output table header
            echo '<tr>';
            for ($i = 0; $i < $result->numColumns(); $i++) {
                // Use conditional statement to apply different styles for odd and even headers
                $style = ($i % 2 == 0) ? 'style="font-size: 16pt; padding: 10px; border: 3px solid black; background-color: gray; color: white;"' : 'style="font-size: 16pt; padding: 10px; border: 3px solid black; background-color: gray; color: white;"';
                echo '<th ' . $style . '>' . $result->columnName($i) . '</th>';
            }
            // Add an additional column for actions
            echo '<th style="border: 3px solid black; font-size: 16pt; font-weight: bolder; background-color: gray; color: white;">Actions</th>';
            echo '</tr>';

            // Output table rows
            $rowNumber = 0; // Counter for alternating row styles
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                // Use conditional statement to apply different styles for odd and even rows
                $rowStyle = ($rowNumber++ % 2 == 0) ? 'style="background-color: #ccc;"' : 'style="background-color: white;"';
                echo '<tr ' . $rowStyle . '>';
                foreach ($row as $value) {
                    echo '<td style="font-size: 14pt; padding: 10px; text-align: center; border: 3px solid black; font-weight: bolder;">' . $value . '</td>';
                }

                // Check if 'id' key exists in the $row array
                $idColumnExists = isset($row['id']);

                // Add edit and delete buttons for each row
                echo '<td style="font-size: 14pt; padding: 10px; text-align: center; border: 3px solid black; font-weight: bolder;">';

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


    <!-- Add this script at the end of your HTML body -->
    <script>
        function openAddForm() {
            // Redirect to the add_entry.php page with the table name
            window.location.href = "add_entry.php?table=<?php echo $tableName; ?>";
        }

        function confirmDelete(deleteUrl) {
            var confirmDelete = confirm("Are you sure you want to delete this entry?");
            if (confirmDelete) {
                // Use AJAX to call the PHP script to update sqlite_sequence
                updateSqliteSequence('<?php echo $tableName; ?>');
                // Redirect to delete entry URL
                window.location.href = deleteUrl;
            }
        }

        function updateSqliteSequence(tableName) {
            // Use AJAX to call the PHP script to update sqlite_sequence
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'update_sqlite_sequence.php?table=' + tableName, true);
            xhr.send();
        }
    </script>

</body>

</html>