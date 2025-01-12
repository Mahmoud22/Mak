<?php
include('conn.php');

// Get the data from POST
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$name = $_POST['name'];
$type = $_POST['type'];
$U = $_POST['U'];

$response = ['status' => 'error', 'message' => 'حدث خطأ.'];

try {
    if ($id) {
        // Update existing record
        $sql = "UPDATE g_category SET name = :name, type = :type, U_measurement = :U WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':U', $U);
        $stmt->bindParam(':id', $id);
    } else {
        // Insert new record
        $sql = "INSERT INTO g_category (name, type, U_measurement) VALUES (:name, :type, :U)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':U', $U);
    }

    // Execute the query
    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'تم الحفظ بنجاح!'];
    }
} catch (PDOException $e) {
    $response = ['status' => 'error', 'message' => 'حدث خطأ: ' . $e->getMessage()];
}

echo json_encode($response);
?>
