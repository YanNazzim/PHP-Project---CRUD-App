
<html>

<head>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1 id="dashHeading">Dashboard</h1>
    <?php
    require_once 'db.php';
    
    // Create a new instance of the Database class
    $database = new Database('Tables.db');
    
    // Get the database connection
    $db = $database->getDB();
    ?>

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
            
            echo '<li id="tableName" style="display: flex; align-items: center;"><a style="background-color: #5a5a5a; text-decoration: none; color: white; display: inline-block; transition: transform 0.3s;" 
            onmouseover="this.style.backgroundColor=\'black\'; this.style.transform=\'scale(1.1)\'" 
            onmouseout="this.style.backgroundColor=\'#5a5a5a\'; this.style.transform=\'scale(1)\'" 
            href="display_table.php?table=' . $tableName . '">' . $capitalizedName . '</a></li>';

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