<?php
// Database connection (replace with your credentials)
$host = 'localhost';
$dbname = 'const';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Handle the AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected checkbox ID and the number of rows
    $checkboxID = $_POST['checkboxID'];
    $inputRow = $_POST['inputRow'];

    // Initialize the checkbox values and the g_name
    $checkboxes = [];
    $g_name = '';  // Initialize g_name variable

    // Query to get the data for the group names (g_name) from the database
    $sql = "SELECT g_name FROM ground WHERE g_name = :checkboxID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['checkboxID' => $checkboxID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $g_name = $result['g_name']; // Fetch the group name
    } else {
        echo "No group found for the selected checkbox.";
        exit;
    }

    // Define the sets of checkboxes based on the checkboxID
    switch ($checkboxID) {
        case 'checkbox1':
            $checkboxes = ['A1', 'A2', 'A3', 'A4', 'A5'];
            break;
        case 'checkbox2':
            $checkboxes = ['B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8'];
            break;
        case 'checkbox3':
            $checkboxes = ['C1', 'C2', 'C3', 'D1', 'D2', 'D3', 'E1', 'E2'];
            break;
        case 'checkbox4':
            $checkboxes = ['D1', 'D2', 'D3'];
            break;
        case 'checkbox5':
            $checkboxes = ['E1', 'E2', 'E3', 'E4', 'E5', 'E6'];
            break;
        case 'checkbox6':
            $checkboxes = ['F1', 'F2', 'F3'];
            break;
        case 'checkbox7':
            $checkboxes = ['G1', 'G2', 'G3', 'G4', 'G5'];
            break;
        case 'checkbox8':
            $checkboxes = ['H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'H7', 'H8', 'H9', 'H10'];
            break;
        case 'checkbox9':
            $checkboxes = ['I1', 'I2', 'I3', 'I4', 'I5', 'I6', 'I7', 'I8'];
            break;
        case 'checkbox10':
            $checkboxes = ['J1', 'J2', 'J3', 'J4', 'J5', 'J6', 'J7'];
            break;
        case 'checkbox11':
            $checkboxes = ['K1', 'K2', 'K3', 'K4', 'K5'];
            break;
        default:
            echo 'Invalid checkbox ID';
            exit;
    }

    // Generate HTML for the g_name, checkboxes, and input fields dynamically for the given row number
    $output = '';

    // Loop to display the group name and checkboxes as many times as the row number
    for ($i = 1; $i <= $inputRow; $i++) {
        $output .= '<div class="group-container ' . $checkboxID . '">';
        $output .= '<h3>Group: ' . htmlspecialchars($g_name) . ' - Row ' . $i . '</h3>';
        $output .= '<label for="g_name_input_' . $i . '">Enter Text for Row ' . $i . ':</label>';
        $output .= '<input type="text" name="g_name_input_' . $i . '" id="g_name_input_' . $i . '" placeholder="Enter text for row ' . $i . '"><br><br>';
        
        // Loop through the checkboxes array and display them
        foreach ($checkboxes as $checkbox) {
            $output .= '<label><input type="checkbox" name="' . $checkbox . '[]"> ' . $checkbox . '</label><br>';
        }

        $output .= '</div><br>';
    }

    // Return the HTML to be injected into the front-end
    echo $output;
}
?>
