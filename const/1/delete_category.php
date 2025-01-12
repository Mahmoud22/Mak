<?php
include('conn.php');

$response = ['status' => 'error', 'message' => 'حدث خطأ.'];

try {
    $id = intval($_POST['id']);

    // Prepare SQL query with a placeholder for the ID
    $sql = "DELETE FROM g_category WHERE id = :id";
    $stmt = $conn->prepare($sql);

    // Bind the ID parameter
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query
    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'تم الحذف بنجاح!'];
    }
} catch (Exception $e) {
    // Handle any errors
    $response = ['status' => 'error', 'message' => 'حدث خطأ: ' . $e->getMessage()];
}

echo json_encode($response);

// Close the database connection
$conn = null;
?>
