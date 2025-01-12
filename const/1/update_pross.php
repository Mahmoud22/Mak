<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'logistic');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	// Get the posted data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $product_name = $_POST['product_name'];
    $from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
    $Total = $_POST['Total'];
    $vehicle_type = $_POST['vehicle_type'];
    $quantity = $_POST['quantity'];
    $weight = $_POST['weight'];
    $unit = $_POST['unit'];
    $date_time = $_POST['date_time'];



    // Prepare and execute the update statement
    $stmt = $conn->prepare("UPDATE client SET name = ?, product_name = ?, from_date = ?, to_date = ?, Total = ?, vehicle_type = ?, quantity = ?, weight = ?, unit = ?, date_time = ? WHERE id = ?");
    
    // Check if prepare failed
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssisiissi", $name, $product_name, $from_date, $to_date, $Total, $vehicle_type, $quantity, $weight, $unit, $date_time, $id);
    
    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo "Item updated successfully!";
    } else {
        echo "Error updating item: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the update form or another page
    header("Location: index.php?id=$id");
    exit();
}
?>