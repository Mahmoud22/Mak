<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>الخدمات</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>صفحة كنترول الخدمات</h2>

        <!-- Country Dropdown -->
        <label for="country">الخدمات الرئيسية</label>
        <select id="country" name="country" style="width: 200px;">
            <option value="">اختر الخدمة الرئيسية</option>
            <?php
            // Fetch countries from the database
            include('conn.php');
            $query = "SELECT * FROM countries";
            $result = $conn->query($query);
            while($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['country_name'] . '</option>';
            }
            ?>
        </select>
		        <!-- Buttons for Add, Update, and Delete -->



        <!-- State Dropdown (Initially Empty) -->
        <label for="state">الخدمات الفرعية</label>
        <select id="state" name="state" style="width: 200px;">
            <option value="">اختر الخدمة الفرعية</option>
        </select>


   <script>
    $(document).ready(function() {
        // Initialize Select2 for better dropdowns
        $('#country').select2();
        $('#state').select2();

        // Fetch states based on selected country
        $('#country').on('change', function() {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    url: 'fetch_data.php',
                    method: 'POST',
                    data: { country_id: country_id },
                    success: function(response) {
                        var states = JSON.parse(response);
                        $('#state').empty().append('<option value="">اختر من القائمة</option>');
                        $.each(states, function(index, state) {
                            $('#state').append('<option value="'+ state.id +'">'+ state.state_name +'</option>');
                        });
                        $('#state').select2();  // Reinitialize Select2
                    }
                });
            } else {
                $('#state').empty().append('<option value="">اختر من القائمة</option>');
                $('#state').select2();  // Re-initialize Select2
            }
        });
// Add Country (Form submission)
$('#addCountryForm').submit(function(e) {
    e.preventDefault();

    var country_name = $('#newCountryName').val();

    if (!country_name) {
        alert('Please provide a Country Name.');
        return;
    }

    $.ajax({
        url: 'fetch_data.php',
        method: 'POST',
        data: { action: 'add_country', country_name: country_name },
        success: function(response) {
            var res = JSON.parse(response);
            alert(res.message);

            // If successful, append the new country to the dropdown
            if (res.status === 'success') {
                $('#country').append('<option value="'+ res.country_id +'">'+ country_name +'</option>');
                $('#country').val(res.country_id).trigger('change'); // Optionally select the new country
            }
            $('#addCountryModal').hide(); // Hide modal after adding country
            $('#newCountryName').val(''); // Clear the input field
        },
        error: function() {
            alert('Error while adding country. Please try again.');
        }
    });
});

        // Open Add Country Modal
        $('#addCountryBtn').click(function() {
            $('#addCountryModal').show();
        });

        // Add Country (Form submission)
        $('#addCountryForm').submit(function(e) {
            e.preventDefault();
            var country_name = $('#newCountryName').val();
            if (!country_name) {
                alert('Please provide a Country Name.');
                return;
            }
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { action: 'add_country', country_name: country_name },
                success: function(response) {
                    var res = JSON.parse(response);
                    alert(res.message);
                    if (res.status === 'success') {
                        $('#country').append('<option value="'+ res.country_id +'">'+ country_name +'</option>');
                        $('#country').val(res.country_id).trigger('change'); // Optional: Set newly added country as selected
                    }
                    $('#addCountryModal').hide();
                    $('#newCountryName').val('');
                },
                error: function() {
                    alert('Error while adding country. Please try again.');
                }
            });
        });

       
      

       

        // Open Update State Modal
        $('#updateStateBtn').click(function() {
            var state_id = $('#state').val();
            if (!state_id) {
                alert('يرجى اختيار الخدمة الفرعية المراد تعديلها');
                return;
            }
            var state_name = $('#state option:selected').text();
            var price = $('#state option:selected').data('price');
            $('#updateStateName').val(state_name);
            $('#updateStatePrice').val(price);
            $('#updateStateId').val(state_id);
            $('#updateStateModal').show();
        });

        // Update State (Form submission)
        $('#updateStateForm').submit(function(e) {
            e.preventDefault();
            var state_id = $('#updateStateId').val();
            var state_name = $('#updateStateName').val();
            var price = $('#updateStatePrice').val();
            if (!state_id || !state_name || !price) {
                alert('Please provide all fields.');
                return;
            }
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { action: 'update_state', state_id: state_id, state_name: state_name, price: price },
                success: function(response) {
                    var res = JSON.parse(response);
                    alert(res.message);
                    if (res.status === 'success') {
                        $('#state option:selected').text(state_name);
                    }
                    $('#updateStateModal').hide();
                },
                error: function() {
                    alert('Error while updating state. Please try again.');
                }
            });
        });

        // Delete State
        $('#deleteStateBtn').click(function() {
            var state_id = $('#state').val();
            if (!state_id) {
                alert('يرجى اختيار الخدمة المراد حذفها');
                return;
            }
            if (confirm('Are you sure you want to delete this state?')) {
                $.ajax({
                    url: 'fetch_data.php',
                    method: 'POST',
                    data: { action: 'delete_state', state_id: state_id },
                    success: function(response) {
                        var res = JSON.parse(response);
                        alert(res.message);
                        if (res.status === 'success') {
                            $('#state option:selected').remove();
                            $('#state').trigger('change');
                        }
                    },
                    error: function() {
                        alert('Error while deleting state. Please try again.');
                    }
                });
            }
        });
    });
</script>

</body>
</html>
