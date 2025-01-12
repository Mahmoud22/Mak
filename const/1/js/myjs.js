$(document).ready(function () {
    Insert_record();  // If you're adding new records, adjust for services
    view_record();    // Viewing services records
    get_record();     // Getting a specific service record to edit
    update_record();  // Updating a specific service record
    delete_record();  // Deleting a specific service record
});

// Insert Record into the Database (Modify this for services)
function Insert_record() {
    $(document).on('click', '#btn_register', function () {
        var type = $('#type').val();  // Adjust for service type
        var name = $('#services_name').val();
        var price = $('#price').val();
		var type_account = $('#type_account').val();


        if (type == "" || name == "" || price == "" || type_account == "") {
            $('#message').html('Please Fill in all fields');
        } else {
            $.ajax({
                url: 'view.php',
                method: 'post',
                data: { type: type, services_name: name, price: price },
                success: function (data) {
                    $('#message').html(data);
                    $('#Registration').modal('show');
                    $('form').trigger('reset');
                    view_record(); // Refresh the records after insertion
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

// Display Record
function view_record() {
    $.ajax({
        url: 'view.php',  // Ensure this PHP file is displaying services data
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

// Get Particular Record (to edit a specific service)
function get_record() {
    $(document).on('click', '#btn_edit', function () {
        var serviceID = $(this).attr('data-id'); // This should be the service ID
        console.log("Service ID for editing:", serviceID); // Debugging
        $.ajax({
            url: 'services_update.php',  // Adjust PHP file as needed to fetch service data
            method: 'post',
            data: { id: serviceID },
            dataType: 'JSON',
            success: function (data) {
                $('#update_id').val(data.id);  // Populate hidden input with ID
                $('#update_type').val(data.type);  // Populate type field
                $('#update_services_name').val(data.services_name);  // Populate name field
                $('#update_price').val(data.price);  // Populate price field
				$('#update_type_account').val(data.price);  // Populate type_account field

                $('#update').modal('show');  // Show the update modal
            },
            error: function(xhr, status, error) {
                console.error("Error fetching record:", status, error);
                $('#message').html('Failed to fetch record. Please try again later.');
            }
        });
    });
}

// Update Record (update service details)
function update_record() {
    $(document).on('click', '#btn_update', function () {
        var updateID = $('#update_id').val();
        var updateType = $('#update_type').val();
        var updateName = $('#update_services_name').val();
        var updatePrice = $('#update_price').val();
        var updateType_account = $('#update_type_account').val();

        if (updateType == "" || updateName == "" || updatePrice == "" || updateType_account == "") {
            $('#up-message').html('Please Fill in all fields');
            $('#update').modal('show');
        } else {
            $.ajax({
                url: 'services_update.php',  // Use your update PHP script
                method: 'post',
                data: {
                    id: updateID,
                    type: updateType,
                    services_name: updateName,
                    price: updatePrice
                },
                success: function (data) {
                    if (data.includes('success')) {
                        $('#up-message').html('Update successful');
                    } else {
                        $('#up-message').html('Error: ' + data);
                    }
                    $('#update').modal('show');
                    view_record();  // Refresh the records after update
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

// Delete Function (delete a specific service record)
function delete_record() {
    $(document).on('click', '#btn_delete', function () {
        var serviceID = $(this).attr('data-id1');  // Get the service ID for deletion
        console.log("Service ID for deletion:", serviceID); // Debugging
        $('#delete').modal('show');  // Show delete confirmation modal

        $(document).off('click', '#btn_delete_record').on('click', '#btn_delete_record', function () {
            $.ajax({
                url: 'services_delete.php',  // Adjust PHP file for delete functionality
                method: 'post',
                data: { id: serviceID },  // Send service ID for deletion
                success: function (data) {
                    if (data.includes('success')) {
                        $('#delete-message').html('Record deleted successfully').fadeOut(5000);
                    } else {
                        $('#delete-message').html('Error: ' + data).fadeOut(5000);
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
