<?php
require_once 'conn.php';  // Include your DB connection

// Check if the ID is provided in the POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // Prepare the DELETE statement
        $query = "DELETE FROM projects WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            echo 'success';  // Successfully deleted
        } else {
            echo 'error';  // Error during deletion
        }
    } catch (PDOException $e) {
        // Catch any errors during the execution
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request';  // If 'id' is not provided
}
?>
