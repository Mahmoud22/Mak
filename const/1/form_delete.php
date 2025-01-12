<?php
require_once('conn.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Get the ID and validate it

    // Validate the input ID
    if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit();
    }

    // Begin a transaction to ensure atomicity
    $conn->beginTransaction();

    try {
        // Delete related rows from operation_services table
        $stmt1 = $conn->prepare("DELETE FROM operation_services WHERE operation_id = :id");
        if (!$stmt1) {
            throw new Exception("Failed to prepare statement for operation_services.");
        }
        $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
        if (!$stmt1->execute()) {
            throw new Exception("Failed to delete from operation_services.");
        }

        // Delete the row from the operations table
        $stmt2 = $conn->prepare("DELETE FROM operations WHERE id = :id");
        if (!$stmt2) {
            throw new Exception("Failed to prepare statement for operations.");
        }
        $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
        if (!$stmt2->execute()) {
            throw new Exception("Failed to delete from operations.");
        }

        // Commit the transaction to finalize changes
        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'تم الحذف بنجاح']);
    } catch (Exception $e) {
        // Rollback the transaction in case of failure
        $conn->rollBack();
        error_log("Error deleting record (ID: $id): " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'فشل عملية الحذف']);
    } finally {
        // Close the database connection
        $conn = null;
    }
} else {
    // Handle invalid requests
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
exit();
?>
