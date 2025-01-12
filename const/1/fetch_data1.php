<?php
include('conn.php'); // Database connection

// Check if the POST variables are set
if (isset($_POST['num_rows']) && isset($_POST['client_id'])) {
    $num_rows = $_POST['num_rows'];
    $client_id = $_POST['client_id'];

    // Fetch ground categories for dropdowns
    $g_categories_query = "SELECT g_category_id, name FROM g_category";
    $g_categories_result = $conn->query($g_categories_query);

    // Check if the query executed successfully
    if (!$g_categories_result) {
        die("Error fetching ground categories: " . $conn->error);
    }

    // Fetch the selected client details (optional, just for verification)
    $client_query = "SELECT client_name FROM client WHERE client_id = ?";
    $stmt = $conn->prepare($client_query);

    // Check if prepare() was successful
    if ($stmt === false) {
        die("Error preparing the client query: " . $conn->error);  // Log the SQL error
    }

    // Bind parameters and execute the query
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $client_result = $stmt->get_result();

    // Check if the client exists
    if ($client_result->num_rows > 0) {
        $client = $client_result->fetch_assoc();
        $client_name = $client['client_name']; // Client name for use in the form
    } else {
        die("Client not found.");
    }

    // Generate the dynamic form HTML
    $form_html = '';

    for ($i = 1; $i <= $num_rows; $i++) {
        $form_html .= "<div class='form_row' id='row_$i'>
                        <h3>Row $i</h3>
                        
                        <!-- Ground Name Dropdown -->
                        <label for='g_name_$i'>Ground Name:</label>
                        <select id='g_name_$i' name='g_name_$i' required>
                            <option value=''>Select Ground</option>";

        // Loop through categories and generate options for the ground name
        while ($category = $g_categories_result->fetch_assoc()) {
            $form_html .= "<option value='" . $category['g_category_id'] . "'>" . htmlspecialchars($category['name']) . "</option>";
        }

        $form_html .= "</select><br>";

        // Type Radio Buttons (ترميم, انشاء, هدم)
        $form_html .= "<label for='type_$i'>Type:</label>
                        <input type='radio' name='type_$i' value='ترميم'> ترميم
                        <input type='radio' name='type_$i' value='انشاء'> انشاء
                        <input type='radio' name='type_$i' value='هدم'> هدم<br>";

        // Client Name (Hidden Field)
        $form_html .= "<label for='client_name_$i'>Client name: $client_name</label>
                        <input type='hidden' value='$client_name' id='client_name_$i' name='client_name_$i'><br>";

        // Input fields for L, SH, H
        $form_html .= "<label for='L_$i'>L:</label>
                        <input type='number' id='L_$i' name='L_$i' required><br>
                        <label for='SH_$i'>SH:</label>
                        <input type='number' id='SH_$i' name='SH_$i' required><br>
                        <label for='H_$i'>H:</label>
                        <input type='number' id='H_$i' name='H_$i' required><br>";

        // Result field
        $form_html .= "<label for='result_$i'>Result:</label>
                        <input type='text' id='result_$i' name='result_$i' readonly><br>";

        // Checkboxes A1 to K5
        $checkboxes = '';
        for ($j = 1; $j <= 11; $j++) {
            $checkboxes .= "<label for='A{$j}_$i'>A$j:</label>
                            <input type='checkbox' name='A_{$i}[]' class='checkbox' data-row-id='$i' value='{$j}'>";
        }

        $form_html .= $checkboxes;

        // Sum field
        $form_html .= "<label for='sum_$i'>Sum:</label>
                        <input type='text' id='sum_$i' name='sum_$i' readonly><br><br>";

        $form_html .= "</div>";
    }

    // Return the generated form HTML
    echo $form_html;
}
?>
