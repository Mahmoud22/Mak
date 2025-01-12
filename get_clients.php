<?php
require_once 'conn.php';  // Include your DB connection

try {
    // Prepare the SQL query using PDO
    $sql = "SELECT * FROM clients";
    $stmt = $conn->prepare($sql);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch all results
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if there are any results
    if ($clients) {
        echo json_encode($clients);
    } else {
        echo json_encode(["error" => "No clients found"]);
    }
} catch (PDOException $e) {
    // Handle any errors during the query execution
    echo json_encode(["error" => "Error fetching clients: " . $e->getMessage()]);
}
?>
