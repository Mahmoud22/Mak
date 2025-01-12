<?php 
require_once('conn.php');  // Include your PDO DB connection

// Insert data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        // Prepare the INSERT query
        $stmt = $conn->prepare("INSERT INTO services (`type`, `name`, `price`) VALUES (?, ?, ?)");

        // Bind the parameters
        $stmt->bindParam(1, $type, PDO::PARAM_STR);
        $stmt->bindParam(2, $name, PDO::PARAM_STR);
        $stmt->bindParam(3, $price, PDO::PARAM_INT);

        // Set parameters and execute
        $type = $_POST['type'];
        $name = $_POST['name'];
        $price = $_POST['price'];

        if ($stmt->execute()) {
            // Redirect back to the page after success
            header("Location: services.php");
            exit;
        } else {
            echo "Error: Could not execute the query.";
        }

    } catch (PDOException $e) {
        // Handle PDO errors
        echo "Error: " . $e->getMessage();
    }
}
?>
