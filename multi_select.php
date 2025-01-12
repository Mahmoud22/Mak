<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الخدمات</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>صفحة كنترول الخدمات</h2>

        <!-- Client Dropdown -->
        <label for="client">العملاء</label>
        <select id="client" name="client" style="width: 200px;">
            <option value="">اختر العميل</option>
            <?php
            // Fetch clients from the database
            include('conn.php');
            $query = "SELECT * FROM clients";
            $result = $conn->query($query);
            while($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['client_name'] . '</option>';
            }
            ?>
        </select>

        <!-- Buttons for Add, Update, and Delete -->
        <button id="addClientBtn">اضافة عميل</button>
        <button id="updateClientBtn">تعديل عميل</button>
        <button id="deleteClientBtn">حذف عميل</button>

        <br><br>

        <!-- Project Dropdown -->
        <label for="project">المشاريع</label>
        <select id="project" name="project" style="width: 200px;">
            <option value="">اختر المشروع</option>
        </select>

        <br><br>

        <!-- Add, Edit, Delete Project Buttons -->
        <button id="addProjectBtn">اضافة مشروع</button>
        <button id="updateProjectBtn">تعديل مشروع</button>
        <button id="deleteProjectBtn">حذف مشروع</button>
    </div>

    <script>
      $(document).ready(function() {
    // Initialize Select2
    $('#client').select2();
    $('#project').select2();

    // Fetch projects based on selected client
    $('#client').on('change', function() {
        var client_id = $(this).val();
        if (client_id) {
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { client_id: client_id },
                success: function(response) {
                    var projects = JSON.parse(response);
                    $('#project').empty().append('<option value="">اختر المشروع</option>');
                    $.each(projects, function(index, project) {
                        $('#project').append('<option value="'+ project.id +'">'+ project.project_name +'</option>');
                    });
                    $('#project').select2();  // Reinitialize Select2
                }
            });
        } else {
            $('#project').empty().append('<option value="">اختر المشروع</option>');
            $('#project').select2();  // Reinitialize Select2
        }
    });

    // Add Client
    $('#addClientBtn').click(function() {
        var client_name = prompt("ادخل اسم العميل");
        if (client_name) {
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { action: 'add_client', client_name: client_name },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('تم إضافة العميل بنجاح!');
                        $('#client').append('<option value="'+ res.client_id +'">'+ client_name +'</option>');
                        $('#client').val(res.client_id).trigger('change');
                        $('#client').select2(); // Reinitialize Select2
                    } else {
                        alert(res.message);
                    }
                }
            });
        }
    });

    // Update Client
    $('#updateClientBtn').click(function() {
        var client_id = $('#client').val();
        var client_name = prompt("ادخل اسم العميل الجديد");
        if (client_id && client_name) {
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { action: 'update_client', client_id: client_id, client_name: client_name },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('تم تعديل العميل بنجاح!');
                        $('#client option:selected').text(client_name);
                    } else {
                        alert(res.message);
                    }
                }
            });
        }
    });

    // Delete Client
    $('#deleteClientBtn').click(function() {
        var client_id = $('#client').val();
        if (client_id && confirm("هل أنت متأكد من حذف العميل؟")) {
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { action: 'delete_client', client_id: client_id },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('تم حذف العميل بنجاح!');
                        $('#client option:selected').remove();
                        $('#project').empty().append('<option value="">اختر المشروع</option>');
                        $('#project').select2();  // Reinitialize Select2
                    } else {
                        alert(res.message);
                    }
                }
            });
        }
    });

    // Add Project
    $('#addProjectBtn').click(function() {
        var project_name = prompt("ادخل اسم المشروع");
        var client_id = $('#client').val();
        if (project_name && client_id) {
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { action: 'add_project', project_name: project_name, client_id: client_id },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('تم إضافة المشروع بنجاح!');
                        $('#project').append('<option value="'+ res.project_id +'">'+ project_name +'</option>');
                        $('#project').select2(); // Reinitialize Select2
                    } else {
                        alert(res.message);
                    }
                }
            });
        }
    });

    // Update Project
    $('#updateProjectBtn').click(function() {
        var project_id = $('#project').val();
        var project_name = prompt("ادخل اسم المشروع الجديد");
        if (project_id && project_name) {
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { action: 'update_project', project_id: project_id, project_name: project_name },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('تم تعديل المشروع بنجاح!');
                        $('#project option:selected').text(project_name);
                    } else {
                        alert(res.message);
                    }
                }
            });
        }
    });

    // Delete Project
    $('#deleteProjectBtn').click(function() {
        var project_id = $('#project').val();
        if (project_id && confirm("هل أنت متأكد من حذف المشروع؟")) {
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { action: 'delete_project', project_id: project_id },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('تم حذف المشروع بنجاح!');
                        $('#project option:selected').remove();
                        $('#project').select2();  // Reinitialize Select2
                    } else {
                        alert(res.message);
                    }
                }
            });
        }
    });
});

    </script>
</body>
</html>
