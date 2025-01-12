<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "const");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$clientId = $_GET['client_id'] ?? 0;

// Fetch the selected subclients for the given client
$query = "SELECT subclient_id FROM client_subclient WHERE client_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();

$selectedSubclients = [];
while ($row = $result->fetch_assoc()) {
    $selectedSubclients[] = $row['subclient_id'];
}

// Return the result as a JSON array
echo json_encode($selectedSubclients);

$stmt->close();
$conn->close();
?>
