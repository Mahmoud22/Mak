<?php
require_once('conn.php'); // Include your PDO DB connection

// Fetch items from the database using PDO
$query = "SELECT * FROM services";
$stmt = $conn->prepare($query);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Insert data into the database using PDO
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if connection was successful (PDO handles this internally, no need to explicitly check connection)
    try {
        // Prepare the INSERT query
        $stmt = $conn->prepare("INSERT INTO services (`type`, `name`, `price`, `type_account`) VALUES (?, ?, ?, ?)");

        // Bind the parameters
        $stmt->bindParam(1, $type, PDO::PARAM_STR);
        $stmt->bindParam(2, $name, PDO::PARAM_STR);
        $stmt->bindParam(3, $price, PDO::PARAM_INT);
        $stmt->bindParam(4, $type_account, PDO::PARAM_STR);

        // Set parameters and execute the query
        $type = $_POST['type'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $type_account = $_POST['type_account'];

        if ($stmt->execute()) {
            // Redirect back to the page after success
            header("Location: services.php");
            exit;
        } else {
            echo "Error: " . $stmt->errorInfo()[2]; // PDO error message
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
