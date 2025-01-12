<?php
include('conn.php');

if (isset($_POST['UserID'])) {
    $id = $_POST['UserID'];

    // Fetch the data for the specific id
    $sql = "SELECT * FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Send the data back as JSON
        echo json_encode(array(
            'status' => 'success',
            'id' => $row['id'],
            'services_name' => $row['services_name'],
            'type' => $row['type'],
            'price' => $row['price']
        ));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Record not found.'));
    }
    $stmt->close();
}

$conn->close();
?>
