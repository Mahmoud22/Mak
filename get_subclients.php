<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "const");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$clientId = $_GET['client_id'] ?? 0;

// Fetch subclients based on the selected client
$query = "SELECT id, sub_client_name FROM subclient WHERE client_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();

$subclients = [];
while ($row = $result->fetch_assoc()) {
    $subclients[] = $row;
}

// Return the result as a JSON array
echo json_encode($subclients);

$stmt->close();
$conn->close();
?>
