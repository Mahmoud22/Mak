<?php
require_once 'conn.php';  // Include your DB connection

// Check if the form data is being posted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from POST
    $projectId = isset($_POST['projectId']) ? $_POST['projectId'] : '';
    $clientId = $_POST['client_id'];
    $projectName = $_POST['project_name'];
    $license = $_POST['license'];
    $address = $_POST['address'];
    $startwork = $_POST['startwork'];
    $endwork = $_POST['endwork'];

    // Convert start and end date to 'YYYY-MM-DD' format
    $startwork = date('Y-m-d', strtotime($startwork));
    $endwork = date('Y-m-d', strtotime($endwork));

    try {
        // If no projectId is provided, insert a new project
        if (empty($projectId)) {
            $sql = "
                INSERT INTO projects (client_id, project_name, license, address, startwork, endwork)
                VALUES (?, ?, ?, ?, ?, ?)
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $clientId, PDO::PARAM_INT);
            $stmt->bindParam(2, $projectName, PDO::PARAM_STR);
            $stmt->bindParam(3, $license, PDO::PARAM_STR);
            $stmt->bindParam(4, $address, PDO::PARAM_STR);
            $stmt->bindParam(5, $startwork, PDO::PARAM_STR);
            $stmt->bindParam(6, $endwork, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo 'success';  // Successfully inserted
            } else {
                echo 'Error inserting project';
            }
        } else {
            // Update existing project
            $sql = "
                UPDATE projects 
                SET client_id = ?, project_name = ?, license = ?, address = ?, startwork = ?, endwork = ? 
                WHERE id = ?
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $clientId, PDO::PARAM_INT);
            $stmt->bindParam(2, $projectName, PDO::PARAM_STR);
            $stmt->bindParam(3, $license, PDO::PARAM_STR);
            $stmt->bindParam(4, $address, PDO::PARAM_STR);
            $stmt->bindParam(5, $startwork, PDO::PARAM_STR);
            $stmt->bindParam(6, $endwork, PDO::PARAM_STR);
            $stmt->bindParam(7, $projectId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo 'success';  // Successfully updated
            } else {
                echo 'Error updating project';
            }
        }
    } catch (PDOException $e) {
        // Catch any errors during the execution
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request method';
}
?>
