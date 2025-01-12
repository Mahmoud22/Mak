<?php require_once('conn.php');
include('inc/adminheader.php'); 
include('action.php');
include('delete.php');
?>		
<html>
<head>
  <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />
  <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/js/dataTables.min.js" />
  <link rel="stylesheet" href="css/fonts.css">
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/myjs.js"></script>
</head>

<title>صفحة العملاء</title>
<body>
  <div class="container contact" align="right">  
    <h2>تسجيل العملاء</h2>

    <!-- Button to trigger Insert modal -->
    <h4><br>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#insertModal" align="right">اضافة وحدة</button>
    </h4>

    <!-- Table to display items -->
    <table id="scoreTable" class="table table-bordered table-striped" align="right">
      <thead>
        <tr>
          <th>حذف</th>
          <th>تعديل</th>
          <th>الإسم</th>
          <th>الرقم</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td> 
            <button type="button" class="btn btn-danger deleteBtn" data-id="' . $row['g_category_id'] . '" data-toggle="modal" data-target="#deleteModal">
            <img src="icons/352303_delete_icon.png">
            </button>
            </td>';
            echo '<td>
            <button type="button" class="btn btn-danger updateBtn" data-id="' . $row['g_category_id'] . '" data-name="' . $row['name'] . '" data-toggle="modal" data-target="#updateModal">
            <img src="icons/211781_more_icon.png">
            </button>
            </td>'; 
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['g_category_id'] . '</td>';
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
          <h5 class="modal-title" id="insertModalLabel">إضافة وحدة جديدة</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="ground_action.php" method="post">
            <div class="form-group">
              <label for="name">اسم الوحدة</label>
              <input type="text" class="form-control" id="name" name="name" required placeholder="أدخل اسم الوحدة">
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
                <h5 class="modal-title" id="updateModalLabel">تعديل الوحدة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="ground_update.php" method="POST" id="updateForm">
                    <input type="hidden" name="g_category_id" id="updateG_category_id"> <!-- Hidden input for category ID -->
                    <div class="form-group">
                        <label for="updateName">اسم الوحدة</label>
                        <input type="text" class="form-control" id="updateName" name="name" required placeholder="أدخل اسم الوحدة">
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
          هل أنت متأكد أنك تريد حذف هذه الوحدة؟ هذه العملية لا يمكن التراجع عنها.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">تأكيد</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Form for Deleting Item -->
  <form action="ground_delete.php" method="post" id="deleteForm" style="display:none;">
    <input type="hidden" name="g_category_id" id="deleteG_category_id">
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
        $('#deleteG_category_id').val(itemId);
      });

      // Open the update modal when the update button is clicked
$('.updateBtn').on('click', function() {
    const itemId = $(this).data('id');
    const name = $(this).data('name');
    $('#updateG_category_id').val(itemId);  // Set hidden input field with g_category_id
    $('#updateName').val(name);  // Set the name input field in the update modal
});

      // When the "Confirm" button is clicked in the delete modal, submit the delete form
      $('#confirmDelete').on('click', function() {
        $('#deleteForm').submit();  // Submit the delete form
      });
		
		
    });
  </script>
</body>
</html>