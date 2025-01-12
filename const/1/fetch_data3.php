<?php
// fetch_data.php

include('conn.php');

// Add Country Action
if (isset($_POST['action']) && $_POST['action'] == 'add_country' && isset($_POST['country_name'])) {
    $country_name = $_POST['country_name'];

    // Validate the country name
    if (empty($country_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Country name is required.']);
        exit;
    }

    // Prepare the statement to insert the country into the database
    $stmt = $conn->prepare("INSERT INTO countries1 (country_name) VALUES (?)");

    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare the SQL statement.']);
        exit;
    }

    // Bind the parameter to the prepared statement
    $stmt->bind_param("s", $country_name);

    // Execute the statement
    if ($stmt->execute()) {
        // Get the last inserted country ID
        $country_id = $stmt->insert_id;
        // Return success response
        echo json_encode(['status' => 'success', 'message' => 'Country added successfully!', 'country_id' => $country_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error while adding country.']);
    }

    // Close the statement
    $stmt->close();
}


// Add State Action (Including Price)
if (isset($_POST['action']) && $_POST['action'] == 'add_state') {
    $state_name = $_POST['state_name'];
    $country_id = $_POST['country_id'];
    $price = $_POST['price'];  // Price is now expected in the request

    if (empty($state_name) || empty($country_id) || empty($price)) {
        echo json_encode(['status' => 'error', 'message' => 'State Name, Country, and Price are required.']);
        exit;
    }

    // Insert the new state with price into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO states (state_name, country_id, price) VALUES (?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement.']);
        exit;
    }

    $stmt->bind_param("sii", $state_name, $country_id, $price);

    if ($stmt->execute()) {
        // Get the ID of the newly inserted state
        $state_id = $stmt->insert_id;
        echo json_encode(['status' => 'success', 'message' => 'State added successfully!', 'state_id' => $state_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add state.']);
    }

    // Close statement
    $stmt->close();
}

// Fetch States based on Country ID
if (isset($_POST['country_id'])) {
    $country_id = $_POST['country_id'];

    // Check for valid country_id
    if (!is_numeric($country_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid country ID.']);
        exit;
    }

    // Fetch states based on the selected country ID using a prepared statement
    $stmt = $conn->prepare("SELECT id, state_name FROM states WHERE country_id = ?");
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement.']);
        exit;
    }

    $stmt->bind_param("i", $country_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $states = [];
    while ($row = $result->fetch_assoc()) {
        $states[] = ['id' => $row['id'], 'state_name' => $row['state_name']];
    }

    // Return the states as a JSON response
    echo json_encode($states);

    // Close statement
    $stmt->close();
}




// Update Country Action
if (isset($_POST['action']) && $_POST['action'] == 'update_country' && isset($_POST['country_id']) && isset($_POST['country_name'])) {
    $country_id = $_POST['country_id'];
    $country_name = $_POST['country_name'];

    if (empty($country_id) || empty($country_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Country ID and Country Name are required.']);
        exit;
    }

    // Update the country name
    $stmt = $conn->prepare("UPDATE countries1 SET country_name = ? WHERE id = ?");
    $stmt->bind_param("si", $country_name, $country_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Country updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update country.']);
    }

    $stmt->close();
}

// Delete Country Action
if (isset($_POST['action']) && $_POST['action'] == 'delete_country' && isset($_POST['country_id'])) {
    $country_id = $_POST['country_id'];

    if (empty($country_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Country ID is required.']);
        exit;
    }

    // Delete the country
    $stmt = $conn->prepare("DELETE FROM countries1 WHERE id = ?");
    $stmt->bind_param("i", $country_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Country deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete country.']);
    }

    $stmt->close();
}

// Update State Action (Including Price)
if (isset($_POST['action']) && $_POST['action'] == 'update_state' && isset($_POST['state_id']) && isset($_POST['state_name']) && isset($_POST['price'])) {
    $state_id = $_POST['state_id'];
    $state_name = $_POST['state_name'];
    $price = $_POST['price'];

    if (empty($state_id) || empty($state_name) || empty($price)) {
        echo json_encode(['status' => 'error', 'message' => 'State ID, State Name, and Price are required.']);
        exit;
    }

    // Update the state name and price
    $stmt = $conn->prepare("UPDATE states SET state_name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("sii", $state_name, $price, $state_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'State updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update state.']);
    }

    $stmt->close();
}

// Delete State Action
if (isset($_POST['action']) && $_POST['action'] == 'delete_state' && isset($_POST['state_id'])) {
    $state_id = $_POST['state_id'];

    if (empty($state_id)) {
        echo json_encode(['status' => 'error', 'message' => 'State ID is required.']);
        exit;
    }

    // Delete the state
    $stmt = $conn->prepare("DELETE FROM states WHERE id = ?");
    $stmt->bind_param("i", $state_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'State deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete state.']);
    }

    $stmt->close();
}
?>




