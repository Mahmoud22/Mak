<?php
include('conn.php');

// Debugging: Log incoming POST and FILES data to a file
$debugLogFile = 'debug_log.txt';
$debugData = "----- New Request: " . date('Y-m-d H:i:s') . " -----\n";
$debugData .= "POST Data:\n" . print_r($_POST, true) . "\n";
$debugData .= "FILES Data:\n" . print_r($_FILES, true) . "\n";
file_put_contents($debugLogFile, $debugData, FILE_APPEND);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and validate POST data
    $clientId = isset($_POST['client']) ? $_POST['client'] : null;
    $projectId = isset($_POST['project']) ? $_POST['project'] : null;
    $unitId = isset($_POST['unit']) ? $_POST['unit'] : null;
    $length = isset($_POST['length']) ? floatval($_POST['length']) : 0;
    $width = isset($_POST['width']) ? floatval($_POST['width']) : 0;
    $height = isset($_POST['height']) ? floatval($_POST['height']) : 0;
    $unitsData = isset($_POST['unitsData']) ? json_decode($_POST['unitsData'], true) : array();

    // Validate required fields
    if (empty($clientId) || empty($projectId) || empty($unitId)) {
        echo json_encode(array('status' => 'error', 'message' => 'Missing required fields.'));
        exit;
    }

    // Calculate total area
    $total_area = $length * $width * $height;

    // Handle file uploads
    $photoPath = null;
    $videoPath = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoName = uniqid() . "_" . basename($_FILES['photo']['name']);
        $photoPath = 'uploads/photos/' . $photoName;
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            error_log("Error uploading photo.");
            echo json_encode(array('status' => 'error', 'message' => 'Error uploading photo.'));
            exit;
        }
    }

    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        $videoName = uniqid() . "_" . basename($_FILES['video']['name']);
        $videoPath = 'uploads/videos/' . $videoName;
        if (!move_uploaded_file($_FILES['video']['tmp_name'], $videoPath)) {
            error_log("Error uploading video.");
            echo json_encode(array('status' => 'error', 'message' => 'Error uploading video.'));
            exit;
        }
    }

    try {
        // Begin database transaction
        $conn->beginTransaction();

        // Insert into operations table
        $sql = "INSERT INTO operations 
                (client_id, project_id, g_category_id, length, width, height, total_area, photo_path, video_path)
                VALUES (:client_id, :project_id, :g_category_id, :length, :width, :height, :total_area, :photo_path, :video_path)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':client_id', $clientId, PDO::PARAM_STR);
        $stmt->bindParam(':project_id', $projectId, PDO::PARAM_STR);
        $stmt->bindParam(':g_category_id', $unitId, PDO::PARAM_INT);
        $stmt->bindParam(':length', $length, PDO::PARAM_STR);
        $stmt->bindParam(':width', $width, PDO::PARAM_STR);
        $stmt->bindParam(':height', $height, PDO::PARAM_STR);
        $stmt->bindParam(':total_area', $total_area, PDO::PARAM_STR);
        $stmt->bindParam(':photo_path', $photoPath, PDO::PARAM_STR);
        $stmt->bindParam(':video_path', $videoPath, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert operation.");
        }

        $operation_id = $conn->lastInsertId();

        // Insert services data if provided
        if (!empty($unitsData)) {
            foreach ($unitsData as $unit) {
                if (isset($unit['services'])) {
                    foreach ($unit['services'] as $service) {
                        $service_id = isset($service['serviceId']) ? $service['serviceId'] : null;
                        $quantity = isset($service['quantity']) ? $service['quantity'] : 0;
                        $price = isset($service['price']) ? $service['price'] : 0;
                        $account_type = isset($service['accountType']) ? $service['accountType'] : 'unknown';
                        $result = $quantity * $price;

                        if (empty($service_id) || $quantity <= 0) {
                            continue;
                        }

                        $stmtService = $conn->prepare("INSERT INTO operation_services 
                            (operation_id, g_category_id, service_id, quantity, price, account_type, result) 
                            VALUES (:operation_id, :g_category_id, :service_id, :quantity, :price, :account_type, :result)");

                        $stmtService->bindParam(':operation_id', $operation_id, PDO::PARAM_INT);
                        $stmtService->bindParam(':g_category_id', $unitId, PDO::PARAM_INT);
                        $stmtService->bindParam(':service_id', $service_id, PDO::PARAM_INT);
                        $stmtService->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                        $stmtService->bindParam(':price', $price, PDO::PARAM_INT);
                        $stmtService->bindParam(':account_type', $account_type, PDO::PARAM_STR);
                        $stmtService->bindParam(':result', $result, PDO::PARAM_STR);

                        if (!$stmtService->execute()) {
                            error_log("Error inserting service: " . implode(", ", $stmtService->errorInfo()));
                        }
                    }
                }
            }
        }

        // Commit transaction
        $conn->commit();
        echo json_encode(array('status' => 'success', 'message' => 'Data successfully inserted.'));
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Transaction failed: " . $e->getMessage());
        echo json_encode(array('status' => 'error', 'message' => 'Failed to insert data.'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method.'));
}
?>
