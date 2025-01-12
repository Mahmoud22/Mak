<?php
include('conn.php');

// Get the category from the AJAX request
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = $_GET['category'];

    // Debug: Log category
    error_log("Fetching services for category: " . $category);

    // Prepare the query with PDO
    $query = "SELECT * FROM services WHERE type = :category";

    // Prepare statement
    $stmt = $conn->prepare($query);

    // Bind the category parameter
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);

    // Execute the query
    if ($stmt->execute()) {
        $services = [];

        // Fetch all services
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $services[] = $row; // Add each service to the array
        }

        // Debug: Log services returned
        error_log("Services fetched: " . json_encode($services));

        // Return the services as JSON
        echo json_encode($services);
    } else {
        // Log query error
        error_log("Error in query: " . implode(' ', $stmt->errorInfo()));

        // Return an empty array if query fails
        echo json_encode([]);
    }
} else {
    // Return an empty array if category is missing
    echo json_encode([]);
}
?>
