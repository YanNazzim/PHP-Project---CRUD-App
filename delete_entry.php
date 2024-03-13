<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Entry</title>
    <script>
        function showAlertAndRedirect(message, redirectUrl) {
            alert(message);
            window.location.href = redirectUrl;
        }
    </script>
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

        // Retrieve the current maximum ID
        $maxIdResult = $db->query("SELECT MAX(id) FROM $tableName");
        $maxId = $maxIdResult->fetchArray(SQLITE3_ASSOC)['MAX(id)'];

        // Delete the specified row
        $deleteQuery = "DELETE FROM $tableName WHERE id = $entryId";
        $db->exec($deleteQuery);

        // Update IDs above the deleted row
        for ($i = $entryId + 1; $i <= $maxId; $i++) {
            $updateQuery = "UPDATE $tableName SET id = $i - 1 WHERE id = $i";
            $db->exec($updateQuery);
        }

        // Close the database connection
        $database->closeDB();

        // Notify with an alert and redirect
        echo '<script>';
        echo 'showAlertAndRedirect("Entry deleted successfully.", "display_table.php?table=' . $tableName . '&update_sequence=' . $tableName . '");';
        echo '</script>';
    } else {
        echo '<p>Table and/or ID parameter not specified.</p>';
    }
    ?>
</body>

</html>