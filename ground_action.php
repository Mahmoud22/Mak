<?php
require_once('conn.php'); 

// Fetch items from the database
$query = "SELECT * FROM g_category";
$stmt = $conn->query($query);

// Insert data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        // Prepare SQL for insertion
        $stmt = $conn->prepare("INSERT INTO g_category (name, type) VALUES (:name, :type)");

        // Bind parameters
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);

        // Get POST data and execute query
        $name = $_POST['name'];
        $type = $_POST['type'];

        if ($stmt->execute()) {
            // Redirect back to the page after success
            header("Location: ground.php");
            exit;
        } else {
            echo "Error: Failed to insert record.";
        }

    } catch (PDOException $e) {
        // Error handling for the database operations
        echo "Error: " . $e->getMessage();
    }

    // Close the connection (optional as PDO auto-closes after script ends)
    $conn = null;
}
?>
