<?php

require_once('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get POST data and sanitize
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $type = $_POST['type'];

    try {
        // Prepare SQL for update
        $query = "UPDATE g_category SET name = :name, type = :type WHERE id = :id";
        $stmt = $conn->prepare($query);

        // Bind parameters to the prepared statement
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            header('Location: ground.php?message=updated');
            exit;
        } else {
            echo "Error: Failed to update record.";
        }
    } catch (PDOException $e) {
        // Error handling for the database operations
        echo "Error: " . $e->getMessage();
    }

    // Close the connection (optional)
    $conn = null;
}
?>
