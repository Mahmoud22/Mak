<?php
require_once('conn.php'); // Include your PDO DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);  // Sanitize the ID

    try {
        // Prepare the DELETE query
        $query = "DELETE FROM services WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Bind the parameter
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect after successful deletion
            header('Location: services.php?message=deleted');
            exit;
        } else {
            echo "Error: Could not execute the query.";
        }

    } catch (PDOException $e) {
        // Handle PDO errors
        echo "Error: " . $e->getMessage();
    }
}
?>
