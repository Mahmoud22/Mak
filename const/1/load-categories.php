<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "const";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get categories
$sql = "SELECT id, name FROM g_category";
$result = $conn->query($sql);

// Initialize an array to hold categories
$categories = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $categories[] = $row;  // Add each category to the array
    }
    // Return the categories as JSON
    echo json_encode($categories);
} else {
    echo json_encode([]);
}

// Close connection
$conn->close();
?>
