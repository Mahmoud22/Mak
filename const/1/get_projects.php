<?php
require_once 'conn.php';  // Include your DB connection

// Check if 'id' is set in the request
if (isset($_GET['id'])) {
    $projectId = $_GET['id'];

    try {
        // Prepare and execute the query to fetch project by ID
        $sql = "
            SELECT projects.*, clients.client_name, 
                   DATE_FORMAT(projects.startwork, '%Y-%m-%d') AS startwork, 
                   DATE_FORMAT(projects.endwork, '%Y-%m-%d') AS endwork
            FROM projects 
            LEFT JOIN clients ON projects.client_id = clients.id 
            WHERE projects.id = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $projectId, PDO::PARAM_INT);
        $stmt->execute();

        $project = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the project data or error if not found
        if (empty($project)) {
            echo json_encode(["error" => "Project not found"]);
        } else {
            echo json_encode($project);  // Return the project as an array
        }
    } catch (PDOException $e) {
        // Handle any errors during the query execution
        echo json_encode(["error" => "Error fetching project: " . $e->getMessage()]);
    }
} else {
    try {
        // If 'id' is not set, fetch all projects
        $sql = "
            SELECT projects.*, clients.client_name, 
                   DATE_FORMAT(projects.startwork, '%Y-%m-%d') AS startwork, 
                   DATE_FORMAT(projects.endwork, '%Y-%m-%d') AS endwork
            FROM projects 
            LEFT JOIN clients ON projects.client_id = clients.id
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the list of projects or an empty array if no projects are found
        echo json_encode($projects);
    } catch (PDOException $e) {
        // Handle any errors during the query execution
        echo json_encode(["error" => "Error fetching projects: " . $e->getMessage()]);
    }
}
?>
