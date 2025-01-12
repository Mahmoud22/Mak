<?php
include('conn.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract form data
    foreach ($_POST['g_name'] as $i => $g_name) {
        $type = $_POST['type'][$i];
        $client_name = $_POST['client_name'][$i];
        $L = $_POST['L'][$i];
        $SH = $_POST['SH'][$i];
        $H = $_POST['H'][$i];
        $result = $L * $SH * $H;

        // Calculate A1 to K5
        $sum = 0;
        if (!empty($_POST['A_'.$i])) {
            foreach ($_POST['A_'.$i] as $checkbox_value) {
                $sum += $result * $checkbox_value;
            }
        }

        // Prepare SQL statement to insert into 'ground' table
        $stmt = $conn->prepare("INSERT INTO `ground`(`g_name`, `type`, `client_name`, `L`, `SH`, `H`, `result`, `sum`) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiidii", $g_name, $type, $client_name, $L, $SH, $H, $result, $sum);

        // Execute the query
        if ($stmt->execute()) {
            echo "Row $i inserted successfully.";
        } else {
            echo "Error inserting row $i.";
        }
    }
}
?>
