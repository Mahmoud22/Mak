$(document).ready(function () {
    Insert_record();  // If you're adding new records for ground
    view_record();    // Viewing ground records
    get_record();     // Getting a specific ground record to edit
    update_record();  // Updating a specific ground record
    delete_record();  // Deleting a specific ground record
});

// Insert Record into the Database (Modify this for ground)
function Insert_record() {
    $(document).on('click', '#btn_register', function () {
        var name = $('#name').val(); // Get the unit name
        var type = $('#type').val(); // Get the unit type

        if (name == "" || type == "") {
            $('#message').html('Please fill in all fields');
        } else {
            $.ajax({
                url: 'ground_action.php',
                type: 'POST',
                data: { name: name, type: type, action: 'insert' },  // Send name, type, and action
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        location.reload();  // Reload the page after successful insertion
                    } else {
                        $('#message').html(data.message); // Show error message
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error during Insert Record:", status, error);
                    $('#message').html('An error occurred during insertion. Please try again.');
                }
            });
        }
    });

    $(document).on('click', '#btn_close', function () {
        $('form').trigger('reset');
        $('#message').html('');
    });
}

// Display Ground Records
function view_record() {
    $.ajax({
        url: 'ground_action.php',  // Ensure this PHP file is displaying ground data
        method: 'post',
        success: function (data) {
            try {
                data = $.parseJSON(data);  // Parse JSON response
                if (data.status == 'success') {
                    $('#table').html(data.html); // Display the records in the table
                } else {
                    console.error("Error: Unexpected response format", data);
                }
            } catch (e) {
                console.error("JSON parsing error:", e);
                $('#message').html('Failed to load records. Please try again later.');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error during view_record:", status, error);
            $('#message').html('An error occurred while loading records.');
        }
    });
}

// Get Particular Ground Record (to edit a specific ground record)
function get_record() {
    $(document).on('click', '#btn_edit', function () {
        var groundID = $(this).attr('data-id'); // This should be the ground record ID
        console.log("Ground ID for editing:", groundID); // Debugging
        $.ajax({
            url: 'ground_update.php',  // Adjust PHP file as needed to fetch ground data
            method: 'post',
            data: { id: groundID },
            dataType: 'JSON',
            success: function (data) {
                $('#update_id').val(data.id);  // Populate hidden input with ID
                $('#update_type').val(data.type);  // Populate type field
                $('#update_ground_name').val(data.ground_name);  // Populate name field
                $('#update').modal('show');  // Show the update modal
            },
            error: function(xhr, status, error) {
                console.error("Error fetching ground record:", status, error);
                $('#message').html('Failed to fetch record. Please try again later.');
            }
        });
    });
}

// Update Ground Record (update ground details)
function update_record() {
    $(document).on('click', '#btn_update', function () {
        var updateID = $('#update_id').val();
        var updateType = $('#update_type').val();
        var updateName = $('#update_ground_name').val();

        if (updateType == "" || updateName == "") {
            $('#up-message').html('Please Fill in all fields');
            $('#update').modal('show');
        } else {
            $.ajax({
                url: 'ground_action.php',  // Use your ground update PHP script
                method: 'POST',
                data: {
                    g_category_id: updateID,
                    name: updateName,
                    type: updateType,
                    action: 'update'
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#up-message').html('Update successful');
                        location.reload(); // Reload the page after successful update
                    } else {
                        $('#up-message').html('Error: ' + data.message);
                    }
                    $('#update').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error during update_record:", status, error);
                    $('#up-message').html('An error occurred during update. Please try again.');
                    $('#update').modal('show');
                }
            });
        }
    });
}

// Delete Ground Record (delete a specific ground record)
function delete_record() {
    $(document).on('click', '#btn_delete', function () {
        var groundID = $(this).attr('data-id1');  // Get the ground record ID for deletion
        console.log("Ground ID for deletion:", groundID); // Debugging
        $('#delete').modal('show');  // Show delete confirmation modal

        $(document).off('click', '#btn_delete_record').on('click', '#btn_delete_record', function () {
            $.ajax({
                url: 'ground_delete.php',  // Adjust PHP file for delete functionality
                method: 'POST',
                data: { g_category_id: groundID, action: 'delete' },  // Send ground ID for deletion
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#delete-message').html('Record deleted successfully').fadeOut(5000);
                        location.reload();  // Reload the page after successful deletion
                    } else {
                        $('#delete-message').html('Error: ' + data.message).fadeOut(5000);
                    }
                    view_record();  // Refresh the records after deletion
                },
                error: function(xhr, status, error) {
                    console.error("Error during delete_record:", status, error);
                    $('#delete-message').html('An error occurred during deletion. Please try again.').fadeOut(5000);
                }
            });
        });
    });
}
