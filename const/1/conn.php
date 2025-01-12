<?php
// Database configuration
$host = 'localhost';  // Your database host
$dbname = 'const';    // Your database name
$username = 'root';   // Your database username
$password = '';       // Your database password

try {
    // Create connection using PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
    // Handle error if connection fails
    die("Connection failed: " . $e->getMessage());
}

?>
