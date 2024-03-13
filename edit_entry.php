<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Entry</title>
</head>

<body>
    <?php

        // Back to Dashboard Button
        echo '<a href="../project/index.php" style="text-decoration: none; padding: 10px 20px; background-color: #89CFF0; color: white; border-radius: 5px; transition: background-color 0.3s, transform 0.3s; display: inline-block; margin-top: 10px; cursor: pointer;" 
        onmouseover="this.style.backgroundColor=\'#6BA8D0\'; this.style.transform=\'scale(1.05)\'" 
        onmouseout="this.style.backgroundColor=\'#89CFF0\'; this.style.transform=\'scale(1)\'">
        
        <input type="button" value="Back to Dashboard" style="background: none; border: none; color: white; cursor: pointer; transition: transform 0.3s;">
        
        </a>';
        
    require_once 'db.php';

    // Create a new instance of the Database class
    $database = new Database('Tables.db');

    // Get the database connection
    $db = $database->getDB();

    // Check if the 'table' and 'id' parameters are set in the URL
    if (isset($_GET['table']) && isset($_GET['id'])) {
        $tableName = $_GET['table'];
        $entryId = $_GET['id'];

        // Fetch the entry from the specified table based on the ID
        $result = $db->query("SELECT * FROM $tableName WHERE id = $entryId");

        // Check if the entry exists
        if ($result) {
            $entryData = $result->fetchArray(SQLITE3_ASSOC);

            // Render the form with dynamic labels based on table headers
            echo '<form action="update_entry.php" method="post" style="text-align: center; margin-top: 20px;">';
            echo '<table style="margin: auto;">'; // Add table element
            foreach ($entryData as $column => $value) {
                echo '<tr>'; // Start a new table row
                echo '<td><label for="' . $column . '" style="display: block; margin-top: 10px; color:black;">' . $column . '</label></td>';
                echo '<td><input type="text" name="' . $column . '" value="' . $value . '" style="margin-bottom: 10px; padding: 5px;"></td>';
                echo '</tr>'; // End the table row
            }
            echo '</table>'; // End the table element
            echo '<input type="hidden" name="id" value="' . $entryId . '">';
            echo '<input type="hidden" name="table" value="' . $tableName . '">';
            echo '<input type="submit" value="Update" style="font-size: 3em; font-weight:bolder; background-color: #8FED92; color: black; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s, transform 0.3s;" 
        onmouseover="this.style.backgroundColor=\'#7ED482\'; this.style.transform=\'scale(1.05)\'" 
        onmouseout="this.style.backgroundColor=\'#8FED92\'; this.style.transform=\'scale(1)\'">';
            echo '</form>';
        } else {
            echo '<p>Error fetching entry data.</p>';
        }
    } else {
        echo '<p>Table and/or ID parameter not specified.</p>';
    }

    // Close the database connection
    $database->closeDB();
    ?>
</body>

</html>
