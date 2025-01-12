<?php 
include('inc/header.php'); 
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
<title>إدارة العملاء والمشاريع</title>
<body>
    <div class="container contact" align="center">  
	<?php
if (isset($_GET['message']) && isset($_GET['alert'])) {
    $message = $_GET['message'];
    $alert = $_GET['alert'];
    echo "<div class='alert alert-$alert' id='alertMessage'>$message</div>";
}
?>

	
	</div>

    <div class="container contact" align="right">  
        <h2>إدارة العملاء والمشاريع</h2>
        <button type="button" class="add-project-button btn btn-primary" data-toggle="modal" data-target="#projectModal">إضافة مشروع جديد</button>

        <!-- DataTable for displaying projects -->
        <table id="categoryTable" class="table table-striped table-bordered mt-4">
            <thead>
                <tr>
                    <th style="text-align: center">حذف</th>
                    <th style="text-align: center">تعديل</th>
                    <th style="text-align: center">التفاصيل</th>
                    <th style="text-align: center">المشروع</th>
                    <th style="text-align: center">العميل</th>
                    <th style="text-align: center">الرقم</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data rows will be populated dynamically -->
            </tbody>
        </table>
    </div>

<?php
    include_once 'includes/modals_services2.php';
    include_once 'scripts_services2.php';
?>

</body>
</html>
