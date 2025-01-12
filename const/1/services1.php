<?php 
require_once('conn.php');
include('inc/header.php'); 
?>

<?php require_once('conn.php'); ?>


<?php
// Fetch items from the database
$result = $conn->query("SELECT * FROM services1");

// Insert data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO services1 (name) VALUES (?)");
    $stmt->bind_param("ssi", $type, $name, $price); // Correctly bind the parameters

    // Set parameters and execute
    $name = $_POST['name'];

    if ($stmt->execute()) {
        // Redirect back to the page after success
        header("Location: services.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
////
	

    $stmt->close();
    $conn->close();
}
?>

<html><head>
  <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />
  <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
  <link rel="stylesheet" href="css/fonts.css">
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/myjs.js"></script>
</head>

<title>قائمة الخدمات والأسعار</title>
<body>
  <div class="container contact" align="right">  
    <h2>قائمة الخدمات والأسعار</h2>

    <!-- Button to trigger Insert modal -->
    <h4><br>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#insertModal" align="right">اضافة خدمة جديدة</button>
    </h4>
<br>
<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);  // Clear the message
}
?>


    <!-- Table to display items -->
    <table id="scoreTable" class="table table-bordered table-striped" align="right">
      <thead>
        <tr>
          <th>الإسم</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Assuming $result contains the fetched records
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
     
            echo '<td>' . $row['name'] . '</td>';

            echo '</tr>';
        }
        ?>
      </tbody>
    </table>

    <!-- Success Alert -->
    <div align="center">
      <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      </div>
    </div>

  </div>

  <!-- Insert Modal -->
  <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="insertModalLabel">إضافة خدمة جديدة</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="services1.php" method="post">
            <div class="form-group">
              <label for="name">اسم الخدمة</label>
              <input type="text" class="form-control" id="name" name="name" required placeholder="أدخل اسم الخدمة">
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
          <button type="submit" class="btn btn-danger">إضافة</button>
        </div>
          </form>
      </div>
    </div>
  </div>

 <!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">تعديل الخدمة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="services1.php" method="POST" id="updateForm">
                    <input type="hidden" name="services_id" id="updateservices_id"> <!-- Hidden input for category ID -->
                   
                    <div class="form-group">
                        <label for="updateName">اسم الخدمة</label>
                        <input type="text" class="form-control" id="updateName" name="name" required placeholder="أدخل اسم الخدمة">
                    </div>
                 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-danger" form="updateForm">تعديل</button>
            </div>
        </div>
    </div>
</div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          هل أنت متأكد أنك تريد حذف هذه الخدمة؟ هذه العملية لا يمكن التراجع عنها.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">تأكيد</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Form for Deleting Item -->
  <form action="services_delete.php" method="post" id="deleteForm" style="display:none;">
    <input type="hidden" name="services_id" id="deleteservices_id">
    <input type="hidden" name="MM_delete" value="deleteForm">
  </form>

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#scoreTable').DataTable();

      // Open the modal when the delete button is clicked
      $('.deleteBtn').on('click', function() {
        const itemId = $(this).data('id');
        $('#deleteservices_id').val(itemId);
      });

      // Open the update modal when the update button is clicked
      $('.updateBtn').on('click', function() {
        const itemId = $(this).data('id');
        const type = $(this).data('type');
        const name = $(this).data('name');
        const price = $(this).data('price');

        $('#updateservices_id').val(itemId);  // Set hidden input field with services_id
        $('#updateType').val(type);  // Corrected the typo here
        $('#updateName').val(name);  // Set the name input field in the update modal
        $('#updatePrice').val(price);  // Set the price input field in the update modal
      });

      // When the "Confirm" button is clicked in the delete modal, submit the delete form
      $('#confirmDelete').on('click', function() {
        $('#deleteForm').submit();  // Submit the delete form
      });
    });
  </script>
</body>
</html>
