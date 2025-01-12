<?php
include('conn.php');

// Add Client Action
if (isset($_POST['action']) && $_POST['action'] == 'add_client' && isset($_POST['client_name'])) {
    $client_name = $_POST['client_name'];

    // Validate the client name
    if (empty($client_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Client name is required.']);
        exit;
    }

    // Prepare the statement to insert the client into the database
    $stmt = $conn->prepare("INSERT INTO clients (client_name) VALUES (?)");

    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the SQL statement.']);
        exit;
    }

    // Bind the parameter to the prepared statement
    $stmt->bind_param("s", $client_name);

    // Execute the statement
    if ($stmt->execute()) {
        // Get the last inserted client ID
        $client_id = $stmt->insert_id;
        // Return success response
        echo json_encode(['status' => 'success', 'message' => 'Client added successfully!', 'client_id' => $client_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error while adding client.']);
    }

    // Close the statement
    $stmt->close();
}

// Add Project Action
if (isset($_POST['action']) && $_POST['action'] == 'add_project') {
    $project_name = $_POST['project_name'];
    $client_id = $_POST['client_id'];

    if (empty($project_name) || empty($client_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Project Name and Client are required.']);
        exit;
    }

    // Insert the new project into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO projects (project_name, client_id) VALUES (?, ?)");
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement.']);
        exit;
    }

    $stmt->bind_param("si", $project_name, $client_id);

    if ($stmt->execute()) {
        // Get the ID of the newly inserted project
        $project_id = $stmt->insert_id;
        echo json_encode(['status' => 'success', 'message' => 'Project added successfully!', 'project_id' => $project_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add project.']);
    }

    // Close statement
    $stmt->close();
}

// Fetch Projects based on Client ID
if (isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];

    // Validate client_id
    if (!is_numeric($client_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid client ID.']);
        exit;
    }

    // Fetch projects based on the selected client ID using a prepared statement
    $stmt = $conn->prepare("SELECT id, project_name FROM projects WHERE client_id = ? ORDER BY project_name ASC");
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement.']);
        exit;
    }

    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $projects = [];
    while ($row = $result->fetch_assoc()) {
        $projects[] = ['id' => $row['id'], 'project_name' => $row['project_name']];
    }

    // Return the projects as a JSON response
    echo json_encode($projects);

    // Close statement
    $stmt->close();
}

// Update Client Action
if (isset($_POST['action']) && $_POST['action'] == 'update_client' && isset($_POST['client_id']) && isset($_POST['client_name'])) {
    $client_id = $_POST['client_id'];
    $client_name = $_POST['client_name'];

    if (empty($client_id) || empty($client_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Client ID and Client Name are required.']);
        exit;
    }

    // Update the client name
    $stmt = $conn->prepare("UPDATE clients SET client_name = ? WHERE id = ?");
    $stmt->bind_param("si", $client_name, $client_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Client updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update client.']);
    }

    $stmt->close();
}

// Delete Client Action
if (isset($_POST['action']) && $_POST['action'] == 'delete_client' && isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];

    if (empty($client_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Client ID is required.']);
        exit;
    }

    // Delete the client
    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->bind_param("i", $client_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Client deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete client.']);
    }

    $stmt->close();
}

// Update Project Action
if (isset($_POST['action']) && $_POST['action'] == 'update_project' && isset($_POST['project_id']) && isset($_POST['project_name'])) {
    $project_id = $_POST['project_id'];
    $project_name = $_POST['project_name'];

    if (empty($project_id) || empty($project_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Project ID and Project Name are required.']);
        exit;
    }

    // Update the project name
    $stmt = $conn->prepare("UPDATE projects SET project_name = ? WHERE id = ?");
    $stmt->bind_param("si", $project_name, $project_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Project updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update project.']);
    }

    $stmt->close();
}

// Delete Project Action
if (isset($_POST['action']) && $_POST['action'] == 'delete_project' && isset($_POST['project_id'])) {
    $project_id = $_POST['project_id'];

    if (empty($project_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Project ID is required.']);
        exit;
    }

    // Delete the project
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $project_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Project deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete project.']);
    }

    $stmt->close();
}
?>
