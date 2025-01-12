<?php
include('conn.php');

try {
    // Get the category ID from the request, if provided
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    // Prepare the SQL query based on whether an ID is provided
    if ($id) {
        $stmt = $conn->prepare("SELECT * FROM g_category WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare("SELECT * FROM g_category");
    }

    // Execute the query
    $stmt->execute();

    // Fetch all the results
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send JSON response
    echo json_encode($categories);

} catch (Exception $e) {
    // Handle any errors
    http_response_code(500); // Set HTTP response code to 500 for server error
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}

// Close the database connection
$conn = null;
?>
