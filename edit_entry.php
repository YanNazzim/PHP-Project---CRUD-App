<!DOCTYPE html>
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
            echo '<form action="update_entry.php" method="post">';
            foreach ($entryData as $column => $value) {
                echo '<label for="' . $column . '">' . $column . '</label>';
                echo '<input type="text" name="' . $column . '" value="' . $value . '">';
            }
            echo '<input type="hidden" name="id" value="' . $entryId . '">';
            echo '<input type="hidden" name="table" value="' . $tableName . '">';
            echo '<input type="submit" value="Update">';
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