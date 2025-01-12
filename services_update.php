<?php

require_once('conn.php'); // Include your PDO DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize input data
    $id = intval($_POST['id']);
    $type = $_POST['type'];
    $services_name = $_POST['name'];
    $price = $_POST['price'];
    $type_account = $_POST['type_account'];

    try {
        // Prepare the update query
        $query = "UPDATE services SET type = ?, name = ?, price = ?, type_account = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(1, $type, PDO::PARAM_STR);
        $stmt->bindParam(2, $services_name, PDO::PARAM_STR);
        $stmt->bindParam(3, $price, PDO::PARAM_INT);
        $stmt->bindParam(4, $type_account, PDO::PARAM_STR);
        $stmt->bindParam(5, $id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect after successful update
            header('Location: services.php?message=updated');
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
