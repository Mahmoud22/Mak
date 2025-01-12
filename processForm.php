<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Define columns as in the form
    $columns = [
        'g_name', 'A1', 'A2', 'A3', 'A4', 'A5',
        'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8',
        'C1', 'C2', 'C3', 'D1', 'D2', 'D3', 'E1', 'E2',
        'E3', 'E4', 'E5', 'E6', 'E7', 'F1', 'F2', 'F3',
        'G1', 'G2', 'G3', 'G4', 'G5', 'H1', 'H2', 'H3',
        'H4', 'H5', 'H6', 'H7', 'H8', 'H9', 'H10', 'I1',
        'I2', 'I3', 'I4', 'I5', 'I6', 'I7', 'I8', 'J1',
        'J2', 'J3', 'J4', 'J5', 'J6', 'J7', 'K1', 'K2',
        'K3', 'K4', 'K5'
    ];

    // Loop through each column (checkbox group)
    foreach ($columns as $column) {
        if (isset($_POST[$column])) {
            // Process each checkbox field - for example, insert them into the database
            $checkedRows = $_POST[$column];  // This will be an array of rows where the checkbox was checked
            // Loop through $checkedRows and store the checked values in the database
            foreach ($checkedRows as $row) {
                // Example query to insert the selected checkbox row and column name into your database
                $stmt = $pdo->prepare("INSERT INTO gorund (column_name, row_id) VALUES (?, ?)");
                $stmt->execute([$column, $row]);
            }
        }
    }

    echo 'Data processed successfully.';
}
?>
