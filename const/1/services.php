<?php 
require_once('conn.php');
include('inc/header.php'); 
include('services_delete.php');
include('view.php');
?>

<html>
<head>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Custom Fonts -->
    <link rel="stylesheet" href="css/fonts.css">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Custom CSS -->
    <style>
        #categoryTable {
            border: 1px solid #ddd;
            border-collapse: collapse;
            width: 100%;
        }

        #categoryTable th,
        #categoryTable td {
            border: 1px solid #fff;
            padding: 8px;
            text-align: right;
        }

        #categoryTable th {
            background-color: #fff;
            font-weight: bold;
        }

        #categoryTable tr:hover {
            background-color: #fff;
        }

        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<title>قائمة الخدمات والأسعار</title>
<body>
    <div class="container contact" align="right">
        <h2>قائمة الخدمات والأسعار</h2>

        <!-- Button to trigger Insert modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertModal" align="right">اضافة خدمة جديدة</button>

        <!-- Table to display items -->
        <table id="categoryTable" class="table table-striped table-bordered mt-4">
            <thead>
                <tr>
                    <th style="text-align: center">حذف</th>
                    <th style="text-align: center">تعديل</th>
                    <th style="text-align: center">حساب الخدمة</th>
                    <th style="text-align: center">السعر</th>
                    <th style="text-align: center">الإسم</th>
                    <th style="text-align: center">النوع</th>
                    <th style="text-align: center">الرقم</th>
					
                </tr>
            </thead>
            <tbody>
<?php
// Assuming $conn is your PDO connection object

// Prepare the query to fetch records
$query = "SELECT * FROM services";
$stmt = $conn->prepare($query);
$stmt->execute();

// Fetch and display records
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td>
        <button class="btn btn-danger btn-sm deleteBtn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#deleteModal">
            حذف
        </button>
    </td>';
    echo '<td>
        <button class="btn btn-warning btn-sm updateBtn" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-type="' . $row['type'] . '" data-price="' . $row['price'] . '" data-type_account="' . $row['type_account'] . '" data-toggle="modal" data-target="#updateModal">
            تعديل
        </button>
    </td>'; 
    echo '<td>' . htmlspecialchars($row['type_account'], ENT_QUOTES) . '</td>';
    echo '<td>' . htmlspecialchars($row['price'], ENT_QUOTES) . '</td>';
    echo '<td>' . htmlspecialchars($row['name'], ENT_QUOTES) . '</td>';
    echo '<td>' . htmlspecialchars($row['type'], ENT_QUOTES) . '</td>';
    echo '<td>' . htmlspecialchars($row['id'], ENT_QUOTES) . '</td>';
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

    <!-- Include modals from modals.php -->
<?php
$page = basename($_SERVER['PHP_SELF']); // Get the current page name
if ($page === 'form.php') {
    include('includes/modals_form.php');
} else {
    include('includes/modals.php');
}
?>
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            let categoryTable = $('#categoryTable').DataTable();

            // Handle delete button click
            $(document).on('click', '.deleteBtn', function () {
                const itemId = $(this).data('id');
                $('#deleteid').val(itemId);
            });

            // Handle update button click
            $(document).on('click', '.updateBtn', function () {
                const itemId = $(this).data('id');
                const type = $(this).data('type');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const type_account = $(this).data('type_account');

                $('#updateid').val(itemId);
                $('#updateType').val(type);
                $('#updateName').val(name);
                $('#updatePrice').val(price);
                $('#updateType_account').val(type_account);
            });

            // Confirm delete
            $('#confirmDelete').on('click', function () {
                $('#deleteForm').submit();
            });
        });
    </script>
</body>
</html>
