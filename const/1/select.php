<?php
include('conn.php');

// Fetch unit names from the database using PDO
$unit_query = "SELECT * FROM g_category";
$stmt = $conn->query($unit_query);

// Safely build unit options as a JSON array for JavaScript
$unitOptions = [];
if ($stmt) {
    while ($unit = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $unitOptions[] = [
            'value' => htmlspecialchars($unit['id'], ENT_QUOTES, 'UTF-8'), // Ensure safe output
            'name' => htmlspecialchars($unit['name'], ENT_QUOTES, 'UTF-8'), // Handle special characters
            'type' => htmlspecialchars($unit['type'], ENT_QUOTES, 'UTF-8'), // Add the 'type' field here
            'U_measurement' => htmlspecialchars($unit['U_measurement'], ENT_QUOTES, 'UTF-8') // Add the 'U_measurement' field here
        ];
    }
} else {
    error_log("No units found or query failed. Query: $unit_query Error: " . $conn->errorInfo());
}

// Convert unit options to JSON for JavaScript
$unitOptionsJSON = json_encode($unitOptions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

if ($unitOptionsJSON === false) {
    error_log("JSON encoding failed: " . json_last_error_msg());
}

// Fetching data with PDO
$query = "
    SELECT 
        o.client_id,
        o.project_id,
        g.name AS category_name,
        g.type AS category_type,
        s.name AS service_name,
        s.type AS service_type, 
        s.price AS service_price, 
        os.quantity,
        os.price AS operation_service_price,
        os.account_type,
        os.result,
        o.id AS operation_id,
        o.length,
        o.width,
        o.height,
        o.total_area,
        o.photo_path,  
        o.video_path   
    FROM operations o
    JOIN g_category g ON o.g_category_id = g.id
    LEFT JOIN operation_services os ON o.id = os.operation_id
    LEFT JOIN services s ON os.service_id = s.id
";

$stmt = $conn->query($query);

// Check if the query was successful
if (!$stmt) {
    echo "<tr><td colspan='7'>Error fetching data: " . implode(' ', $conn->errorInfo()) . "</td></tr>";
    exit;
}
?>
