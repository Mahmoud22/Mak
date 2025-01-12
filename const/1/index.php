<?php
include('inc/header.php'); 
require_once('conn.php');
include('select.php');
?>

<html>
<head>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Include DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <!-- Include Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Include custom styles and fonts -->
    <link rel="stylesheet" href="css/fonts.css">

    <style>
        .modal-dialog {
            max-width: 90%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            direction: rtl;
        }

        th, td {
            padding: 12px;
            text-align: right;
            word-wrap: break-word;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #e9ecef;
        }

        .collapse-row {
            display: none;
            background-color: #f1f1f1;
        }

        .collapse-btn {
            cursor: pointer;
            color: #007BFF;
            text-decoration: underline;
        }

        .collapse-btn:hover {
            color: #0056b3;
        }
    </style>
</head>
<title>إدارة العمليات</title>

<body>
    <div class="container contact" align="right">
        <h2>إدارة العمليات</h2>

        <!-- Button to open modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#wideModalAdd" style="font-size: 12px; width: 100px;">
            حساب جديد
        </button>

        <!-- Table -->
<div class="table-responsive">
    <table id="categoryTable" class="table table-striped table-bordered table-sm mt-4">
        <thead>
            <tr>
                <th>الرقم</th>
                <th>المشروع</th>
                <th>الوحدة</th>
                <th>تفاصيل</th>
                <th>عرض</th>
                <th>حذف</th>
				
				
				<a href="form.php?client_project=<?= $clientProject ?>">
            </tr>
        </thead>
        <tbody>
            <?php
            if (!$result) {
                echo "<tr><td colspan='6'>خطاء في جلب البيانات " . $conn->error . "</td></tr>";
                exit;
            }

            if ($result->num_rows > 0) {
                $groupedData = array(); // Initialize array for grouped data

                // Group data by operation_id
                while ($row = $result->fetch_assoc()) {
                    $operationId = $row['operation_id'];
                    if (!isset($groupedData[$operationId])) {
                        $groupedData[$operationId] = array(
                            'operation_id' => $row['operation_id'],
                            'client_project' => (isset($row['client_id']) ? $row['client_id'] : 'N/A') . ' - ' . (isset($row['project_id']) ? $row['project_id'] : 'N/A'),
                            'category_name' => isset($row['category_name']) ? $row['category_name'] : 'N/A',
                            'category_type' => isset($row['category_type']) ? $row['category_type'] : 'N/A',
                            'details' => array(),
                        );
                    }

                    // Add service details
                    $groupedData[$operationId]['details'][] = array(
                        'service_name' => isset($row['service_name']) ? $row['service_name'] : 'N/A',
                        'service_type' => isset($row['service_type']) ? $row['service_type'] : 'N/A',
                        'service_price' => isset($row['service_price']) ? $row['service_price'] : 'N/A',
                        'length' => isset($row['length']) ? $row['length'] : 'N/A',
                        'width' => isset($row['width']) ? $row['width'] : 'N/A',
                        'height' => isset($row['height']) ? $row['height'] : 'N/A',
                        'total_area' => isset($row['total_area']) ? $row['total_area'] : 'N/A',
                        'quantity' => isset($row['quantity']) ? $row['quantity'] : 'N/A',
                        'operation_service_price' => isset($row['operation_service_price']) ? $row['operation_service_price'] : 'N/A',
                        'account_type' => isset($row['account_type']) ? $row['account_type'] : 'N/A',
                    );
                }

                // Render the table
                foreach ($groupedData as $operationId => $data) {
                    echo '<tr>';
                    echo '<td>' . $data['operation_id'] . '</td>';
                    echo '<td>' . $data['client_project'] . '</td>';
                    echo '<td>' . $data['category_name'] . ' (' . $data['category_type'] . ')</td>';
                    echo '<td><button class="btn btn-info btn-sm px-2 py-1" data-toggle="collapse" data-target="#detailsRow' . $operationId . '">عرض</button></td>';
                    echo '<td><button type="button" class="btn btn-warning btn-sm px-2 py-1 editBtn">تعديل</button></td>';
                    echo '<td><button type="button" class="btn btn-danger btn-sm px-2 py-1 deleteBtn" data-id="' . $operationId . '">حذف</button></td>';
                    echo '</tr>';

                    // Collapsible row for details
                    echo '<tr id="detailsRow' . $operationId . '" class="collapse">';
                    echo '<td colspan="6">';
                    echo '<p>تفاصيل إضافية للوحدة: <strong>' . $data['category_name'] . ' (' . $data['category_type'] . ')</strong></p>';

                    // Displaying details in a table format
                    echo '<table class="table table-bordered table-sm table-striped">';
                    echo '<thead><tr>
                            <th>الخدمة (النوع)</th>
                            <th>الطول</th>
                            <th>العرض</th>
                            <th>الإرتفاع</th>
                            <th>المساحة الكلية</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>طريقة الحساب</th>
                        </tr></thead>';
                    echo '<tbody>';
                    foreach ($data['details'] as $detail) {
                        echo '<tr>';
                        echo '<td>' . $detail['service_type'] . ' (' . $detail['service_name'] . ')</td>';
                        echo '<td>' . $detail['length'] . '</td>';
                        echo '<td>' . $detail['width'] . '</td>';
                        echo '<td>' . $detail['height'] . '</td>';
                        echo '<td>' . $detail['total_area'] . '</td>';
                        echo '<td>' . $detail['quantity'] . '</td>';
                        echo '<td>' . $detail['service_price'] . '</td>';
                        echo '<td>' . $detail['account_type'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo "<tr><td colspan='6'>No records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<style>
    #categoryTable {
        table-layout: fixed;
        width: 100%;
    }

    #categoryTable th, #categoryTable td {
        word-wrap: break-word;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.85rem;
        padding: 5px;
    }

    .btn-sm {
        font-size: 0.8rem;
        padding: 2px 4px;
    }

    .table-sm th, .table-sm td {
        padding: 0.4rem;
    }

    .collapse td {
        font-size: 0.8rem;
    }

    @media (max-width: 768px) {
        #categoryTable th, #categoryTable td {
            font-size: 0.75rem;
        }

        .btn-sm {
            font-size: 0.7rem;
            padding: 1px 3px;
        }
    }
</style>


    <!-- Include modals -->
    <?php include('includes/modals_form.php'); 
    include_once 'scripts_form.php';
    ?>

</body>
</html>
