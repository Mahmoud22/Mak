<?php 
include('inc/header.php'); 
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الوحدات السكنية</title>

   
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
	
 <!-- Custom CSS to remove table color styles -->
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

.custom-select {
    position: relative;
    width: 200px;
}

.selected {
    padding: 10px;
    border: 1px solid #ccc;
    cursor: pointer;
    background-color: #fff;
}

.options {
    display: none;
    position: absolute;
    border: 1px solid #ccc;
    background-color: #fff;
    z-index: 1000;
    width: 100%;
}

.option {
    padding: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.option img {
    width: 20px; /* Adjust size as needed */
    height: 20px; /* Adjust size as needed */
    margin-right: 10px;
}

.option:hover {
    background-color: #f0f0f0;
}
    </style>
</head>
<body>
    <div class="container contact" align="center">
        <?php if (isset($_GET['message']) && isset($_GET['alert'])): ?>
            <div class="alert alert-<?php echo htmlspecialchars($_GET['alert']); ?>" id="alertMessage">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="container contact" align="right">  
        <h2>إدارة الوحدات السكنية</h2>
        <button type="button" class="btn btn-primary" id="addCategoryBtn">إضافة وحدة جديدة</button>

        <!-- DataTable for displaying categories -->
        <table id="categoryTable" class="table table-striped table-bordered mt-4" align="right">
            <thead>
                <tr>
                    <th style="text-align: center">حذف</th>
                    <th style="text-align: center">تعديل</th>
					<th style="text-align: center">وحدة القياس</th>
                    <th style="text-align: center">مكان الوحدة</th>
                    <th style="text-align: center">اسم الوحدة</th>
                    <th style="text-align: center">رقم</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="categoryModalLabel">إضافة/تعديل وحده سكنية</h4>
                </div>
                <div class="modal-body">
                    <form id="categoryForm">
                        <input type="hidden" id="categoryId" name="id">
                        <div class="form-group">
                            <label for="categoryName">اسم الوحدة</label>
                            <input type="text" id="categoryName" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryType">مكان الوحدة</label>
                            <select class="form-control" id="categoryType" name="type" required>
                                <option>-- اختر من القائمة --</option>
                                <option value="الدور الأرضي">الدور الأرضي</option>
                                <option value="الدور الاول">الدور الاول</option>
                                <option value="الوحدات الخدمية">الوحدات الخدمية</option>
                                <option value="الدرج">الدرج</option>
                                <option value="الحوش">الحوش</option>
                                <option value="الأسوار">الأسوار</option>
                                <option value="واجهات الفيلا">واجهات الفيلا</option>
                                <option value="أخرى">أخرى</option>
                            </select>
                        </div>
						    <div class="form-group">
                            <label for="categoryU">وحدة القياس</label>
                            <select class="form-control" id="categoryU" name="U" required>
                                <option>-- اختر من القائمة --</option>
                                <option value="الطول * العرض * الإرتفاع">الطول * العرض * الإرتفاع</option>
                                <option value="الطول * العرض">الطول * العرض</option>
                                <option value="إجمالي المساحة">إجمالي المساحة</option>

                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {
        let categoryTable = $('#categoryTable').DataTable();
        let categoryModal = $('#categoryModal');
        let categoryForm = $('#categoryForm');

        // Load categories
        function loadCategories() {
            $.ajax({
                url: 'get_categories.php',
                method: 'GET',
                success: function (response) {
                    let categories = JSON.parse(response);
                    categoryTable.clear();
                    categories.forEach(category => {
                        categoryTable.row.add([ 

                            `<button class="btn btn-danger btn-sm deleteBtn" data-id="${category.id}">حذف</button>`,
                            `<button class="btn btn-warning btn-sm editBtn" data-id="${category.id}">تعديل</button>`,
                            category.U_measurement,
							category.type,
                            category.name,
                            category.id
                        ]);
                    });
                    categoryTable.draw();
                }
            });
        }
        loadCategories();

        // Handle Add Button (reset form for new entry)
        $('#addCategoryBtn').click(function () {
            $('#categoryId').val('');
            $('#categoryName').val('');
            $('#categoryType').val('');
            $('#categoryU').val('');
            categoryModal.modal('show');
        });

        // Handle Add/Edit Submission
        categoryForm.submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'insert_update_category.php',
                method: 'POST',
                data: categoryForm.serialize(),
                success: function (response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        categoryModal.modal('hide');
                        loadCategories();
                        alert(res.message);
                    } else {
                        alert(res.message || 'حدث خطأ.');
                    }
                },
                error: function () {
                    alert('تعذر الاتصال بالخادم.');
                }
            });
        });

        // Handle Edit Button
        $(document).on('click', '.editBtn', function () {
            let id = $(this).data('id');
            $.ajax({
                url: 'get_categories.php',
                method: 'GET',
                data: { id },
                success: function (response) {
                    let category = JSON.parse(response)[0];
                    $('#categoryId').val(category.id);
                    $('#categoryName').val(category.name);
                    $('#categoryType').val(category.type);
                    $('#categoryU').val(category.U_measurement);
                    categoryModal.modal('show');
                }
            });
        });

        // Handle Delete Button
        $(document).on('click', '.deleteBtn', function () {
            let id = $(this).data('id');
            if (confirm('هل أنت متأكد؟')) {
                $.ajax({
                    url: 'delete_category.php',
                    method: 'POST',
                    data: { id },
                    success: function (response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            loadCategories();
                            alert(res.message);
                        } else {
                            alert(res.message || 'حدث خطأ.');
                        }
                    },
                    error: function () {
                        alert('تعذر الاتصال بالخادم.');
                    }
                });
            }
        });
    });
</script>
</body>
</html>
