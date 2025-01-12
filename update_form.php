<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize POST data
    $clientId = isset($_POST['client']) ? $conn->real_escape_string($_POST['client']) : null;
    $projectId = isset($_POST['project']) ? $conn->real_escape_string($_POST['project']) : null;
    $unitId = isset($_POST['unit']) ? $conn->real_escape_string($_POST['unit']) : null;
    $length = isset($_POST['length']) ? floatval($_POST['length']) : 0;
    $width = isset($_POST['width']) ? floatval($_POST['width']) : 0;
    $height = isset($_POST['height']) ? floatval($_POST['height']) : 0;
    $unitsData = isset($_POST['unitsData']) ? json_decode($_POST['unitsData'], true) : array();
    $operationId = isset($_POST['id']) ? intval($_POST['id']) : null;

    // Validate mandatory fields
    if (!$clientId || !$projectId || !$unitId) {
        echo json_encode(array('status' => 'error', 'message' => 'Missing required fields.'));
        exit;
    }

    // Check if unitId exists in the database
    $checkUnitQuery = $conn->prepare("SELECT id FROM units WHERE g_category_id = ?");
    $checkUnitQuery->bind_param("s", $unitId);
    $checkUnitQuery->execute();
    $checkUnitResult = $checkUnitQuery->get_result();
    if ($checkUnitResult->num_rows == 0) {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid unit ID.'));
        exit;
    }

    $total_area = $length * $width * $height; // Calculate total area

    if ($operationId) {
        // Update existing record
        $sqlUpdate = $conn->prepare("UPDATE operations SET client_id = ?, project_id = ?, g_category_id = ?, length = ?, width = ?, height = ?, total_area = ? WHERE id = ?");
        $sqlUpdate->bind_param("sssddddi", $clientId, $projectId, $unitId, $length, $width, $height, $total_area, $operationId);
        if (!$sqlUpdate->execute()) {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update operation.'));
            exit;
        }
    } else {
        // Insert new record
        $sqlInsert = $conn->prepare("INSERT INTO operations (client_id, project_id, g_category_id, length, width, height, total_area) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sqlInsert->bind_param("sssdddi", $clientId, $projectId, $unitId, $length, $width, $height, $total_area);
        if (!$sqlInsert->execute()) {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to insert operation.'));
            exit;
        }
        $operationId = $sqlInsert->insert_id;
    }

    // Handle services data
    if (!empty($unitsData)) {
        foreach ($unitsData as $unit) {
            foreach ($unit['services'] as $service) {
                $serviceId = isset($service['serviceId']) ? $conn->real_escape_string($service['serviceId']) : null;
                $quantity = isset($service['quantity']) ? floatval($service['quantity']) : 0;
                $price = isset($service['price']) ? floatval($service['price']) : 0.0;
                $accountType = isset($service['accountType']) ? $conn->real_escape_string($service['accountType']) : 'unknown';
                $type = isset($service['type']) ? $conn->real_escape_string($service['type']) : 'standard';
                $result = $quantity * $price;

                if (!$serviceId || !$quantity) {
                    continue;
                }

                $sqlService = $conn->prepare(
                    "INSERT INTO operation_services (operation_id, g_category_id, service_id, quantity, price, account_type, result, type)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE quantity = ?, price = ?, result = ?"
                );
                $sqlService->bind_param("isssddsddds", $operationId, $unitId, $serviceId, $quantity, $price, $accountType, $result, $type, $quantity, $price, $result);
                if (!$sqlService->execute()) {
                    error_log("Service insertion error: " . $conn->error);
                }
            }
        }
    }

    // Send response
    echo json_encode(array('status' => 'success', 'message' => 'Data successfully inserted/updated.'));
    exit;
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method.'));
    exit;
}
?>
