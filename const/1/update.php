<?php 
include('conn.php');
include('action.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	
    <title>Update Item</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Update Item</h1>

        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'logistic');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch the item to update
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM client WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $item = $result->fetch_assoc();
            $stmt->close();
        } else {
            echo "No ID provided.";
            exit();
        }

        ?>
      <?php  $conn->close(); ?>

	
        <form id="updateForm" action="update_pross.php" method="post">
            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <select class="form-control" id="name" name="name" value="<?php echo $item['name']; ?>" required>
				<option>-- choose client --</option>
		      <?php
		do {  
		?>
		      <option value="<?php echo $row_Recordset3['name']?>"<?php if (!(strcmp($row_Recordset3['name'], $row_Recordset3['name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['name']?></option>
		      <?php
		} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
		$rows = mysql_num_rows($Recordset3);
		if($rows > 0) {
		mysql_data_seek($Recordset3, 0);
		$row_Recordset3 = mysql_fetch_assoc($Recordset3);
		}
		?>
				
				</select>
            </div>
			            <div class="form-group">
                <label for="product_name">product_name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $item['product_name']; ?>" required>
            </div>
			            <div class="form-group">
                <label for="from_date">from date:</label>
                <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo $item['from_date']; ?>" required>
            </div>
			  <div class="form-group">
                <label for="to_date">To date:</label>
                <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo $item['to_date']; ?>" required>
            </div>
			            <div class="form-group">
                <label for="Total">Total:</label>
                <input type="text" class="form-control" id="Total" name="Total" value="<?php echo $item['Total']; ?>" required>
            </div>
			
			<div class="form-group">
                <label for="vehicle_type">vehicle type:</label>
                <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" value="<?php echo $item['vehicle_type']; ?>" required>
            </div>
	
						<div class="form-group">
                <label for="quantity">quantity:</label>
                <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo $item['quantity']; ?>" required>
            </div>
			
			<div class="form-group">
                <label for="weight">weight:</label>
                <input type="text" class="form-control" id="weight" name="weight" value="<?php echo $item['weight']; ?>" required>
            </div>
			
						<div class="form-group">
                <label for="unit">unit:</label>
                <input type="text" class="form-control" id="unit" name="unit" value="<?php echo $item['unit']; ?>" required>
            </div>
			
						<div class="form-group">
                <label for="date_time">date_time:</label>
                <input type="date" class="form-control" id="date_time" name="date_time" value="<?php echo $item['date_time']; ?>" required>
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">Update</button>
        </form>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirm Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to update this item?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmUpdate">Yes, Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript to handle the confirmation
        document.getElementById('confirmUpdate').addEventListener('click', function() {
            document.getElementById('updateForm').submit();
        });
    </script>
</body>
</html>
