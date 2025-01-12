	<?php
	// Include the connection file for PDO
	include('conn.php');


	try {
		// Fetch unit names from the database
		$unit_query = "SELECT * FROM g_category";
		$stmt = $conn->prepare($unit_query);
		$stmt->execute();

		$unitOptions = array();
		while ($unit = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$unitOptions[] = array(
				'value' => htmlspecialchars($unit['id'], ENT_QUOTES, 'UTF-8'),
				'name' => htmlspecialchars($unit['name'], ENT_QUOTES, 'UTF-8'),
				'type' => htmlspecialchars($unit['type'], ENT_QUOTES, 'UTF-8'),
				'U_measurement' => htmlspecialchars($unit['U_measurement'], ENT_QUOTES, 'UTF-8'),
			);
		}

		// Convert unit options to JSON for internal use
		$unitOptionsJSON = json_encode($unitOptions);
		if ($unitOptionsJSON === false) {
			throw new Exception("JSON encoding failed: " . json_last_error_msg());
		}
	} catch (Exception $e) {
		error_log("Error fetching units: " . $e->getMessage());
		echo json_encode(["status" => "error", "message" => "Error fetching units."]);
		exit;
	}


	?>


