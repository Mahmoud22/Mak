<script>
	
$(document).ready(function () {
    let categoryTable = $('#categoryTable').DataTable();

    // Function to load clients
    function loadClients(selectId) {
        $.ajax({
            url: 'get_clients.php',
            method: 'GET',
            success: function (response) {
                let clients = JSON.parse(response);
                let options = '<option value="">اختر العميل</option>';
                clients.forEach(client => {
                    options += `<option value="${client.id}">${client.client_name}</option>`;
                });
                $(selectId).html(options);
            },
            error: function () {
                console.error('حدث خطاء ما');
                $(selectId).html('<option value="">حدث خطاء ما</option>');
            }
        });
    }

    // Load clients into dropdowns
    loadClients('#addClientSelect');
    loadClients('#editClientSelect');

         // Function to load projects and populate DataTable
    function loadProjects() {
        $.ajax({
            url: 'get_projects.php',
            method: 'GET',
            success: function (response) {
                let projects = JSON.parse(response);
                let tableBody = projects.map(project => `
                    <tr>
                        <td>
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="${project.id}" data-toggle="modal" data-target="#deleteModal">حذف</button>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm editBtn" data-id="${project.id}">تعديل</button>
                        </td>
                        <td>
                            <button class="btn btn-info collapse-btn" data-target="#detailsRow${project.id}">عرض</button>
                        </td>
                        <td>${project.project_name}</td>
                        <td>${project.client_name}</td>
                        <td>${project.id}</td>
                    </tr>
                    <tr id="detailsRow${project.id}" class="collapse-row" style="display:none;">
                        <td colspan="10">
                            <p>تفاصيل إضافية للمشروع ${project.project_name}:</p>
                            <ul>
                                <li><strong>رقم الرخصة:</strong> ${project.license}</li>
                                <li><strong>تاريخ بداية العمل:</strong> ${project.startwork}</li>
                                <li><strong>تاريخ الإنتهاء من العمل:</strong> ${project.endwork}</li>
                                <li><strong>العنوان:</strong> ${project.address}</li>
                                <!-- You can add more project details here -->
                            </ul>
                        </td>
                    </tr>
                `).join('');
                $('#categoryTable tbody').html(tableBody);
                $('#categoryTable').DataTable();
            },
            error: function () {
                console.error('Error fetching projects');
            }
        });
    }

    // Initial load
    loadProjects();

// Handle toggle of the collapsible row
    $(document).on('click', '.collapse-btn', function() {
        var target = $(this).data('target');
        var currentText = $(this).text().trim(); // Trim extra whitespace
        var btnText = currentText === "عرض" ? "إخفاء" : "عرض"; // Toggle between "عرض" and "إخفاء"
        
        $(target).toggle(); // Toggle the visibility of the details row
        $(this).text(btnText); // Update the button text
    });
	
    // Handle Add Project Form Submission
    $('#addProjectForm').submit(function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: 'insert_update_project.php',
            method: 'POST',
            data: formData,
            success: function (response) {
                if (response === 'success') {
                    redirectWithMessage('تمت الضافة بنجاح', 'success');
                } else {
                    redirectWithMessage('حدث خطاء ما', 'danger');
                }
            },
            error: function () {
                redirectWithMessage('حدث خطاء ما', 'danger');
            }
        });
    });

    // Handle Edit Button Click
    $(document).on('click', '.editBtn', function () {
        let projectId = $(this).data('id');
        $.ajax({
            url: 'get_projects.php',
            method: 'GET',
            data: { id: projectId },
            success: function (response) {
                let project = JSON.parse(response);
                if (project && project.length > 0) {
                    project = project[0];

                    // Populate modal fields
                    $('#editProjectId').val(project.id);
                    $('#editClientSelect').val(project.client_id);
                    $('#editProjectName').val(project.project_name);
                    $('#editLicense').val(project.license);
                    $('#editAddress').val(project.address);

                    // Format and set dates
                    let startDate = project.startwork.split(' ')[0];
                    let endDate = project.endwork.split(' ')[0];
                    $('#editStartwork').val(startDate);
                    $('#editEndwork').val(endDate);

                    $('#editProjectModal').modal('show');
                } else {
                    showAlert('حدث خطاء ما', 'alert-danger');
                }
            },
            error: function () {
                showAlert('حدث خطاء ما', 'alert-danger');
            }
        });
    });

    // Handle Delete Button Click
    $(document).on('click', '.deleteBtn', function () {
        deleteProjectId = $(this).data('id');
    });

    // Handle Delete Confirmation
    $('#deleteBtn').click(function () {
        $.ajax({
            url: 'delete_project.php',
            method: 'POST',
            data: { id: deleteProjectId },
            success: function (response) {
                if (response === 'success') {
                    redirectWithMessage('تم الحذف بنجاح', 'success');
                } else {
                    redirectWithMessage('حدث خطاء ما', 'danger');
                }
            },
            error: function () {
                redirectWithMessage('حدث خطاء ما', 'danger');
            }
        });
    });

    // Redirect function
    function redirectWithMessage(message, alertType) {
        window.location.href = 'services2.php?message=' + encodeURIComponent(message) + '&alert=' + alertType;
    }

    // Show alert
    function showAlert(message, alertType) {
        $('#alertMessage').html(`<div class="alert ${alertType}">${message}</div>`);
    }
});
	
	

</script>

