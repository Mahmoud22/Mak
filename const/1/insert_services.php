<?php
include('conn.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $services = $_POST['name'];

    // Loop through the services and insert them into the ground table
    foreach ($services as $service) {
        $serviceName = $service['name'];
        $servicePrice = $service['price'];
        $groundField = $service['field']; // Field in the ground table (e.g., A1, B2, etc.)

        // Prepare the SQL query to insert data into the specific ground field
        $query = "UPDATE ground SET `$groundField` = ? WHERE condition = 'some_condition'"; // Modify `condition` as per your needs
        $stmt = $conn->prepare($query);
        $stmt->bind_param('d', $servicePrice); // 'd' for double (price)
        $stmt->execute();
    }

    echo json_encode(['status' => 'success']);
}
?>
