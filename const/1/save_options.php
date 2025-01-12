<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Multi Select Dropdown with Checkboxes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
        }
        .dropdown-menu input {
            margin-right: 10px;
        }
        .btn-group .dropdown-toggle {
            width: 100%;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
        }
        .selected-options {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h3>Dynamic Multi Select Dropdown with Checkboxes</h3>

        <!-- Multi-select Dropdown Button -->
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Select Options
            </button>
            <div class="dropdown-menu">
                <form id="multiSelectForm" action="save_options.php" method="POST">
                    <div class="dropdown-item">
                        <input type="checkbox" id="option1" name="options[]" value="Option 1">
                        <label for="option1">Option 1</label>
                    </div>
                    <div class="dropdown-item">
                        <input type="checkbox" id="option2" name="options[]" value="Option 2">
                        <label for="option2">Option 2</label>
                    </div>
                    <div class="dropdown-item">
                        <input type="checkbox" id="option3" name="options[]" value="Option 3">
                        <label for="option3">Option 3</label>
                    </div>
                    <div class="dropdown-item">
                        <input type="checkbox" id="option4" name="options[]" value="Option 4">
                        <label for="option4">Option 4</label>
                    </div>
                    <div class="dropdown-item">
                        <input type="checkbox" id="option5" name="options[]" value="Option 5">
                        <label for="option5">Option 5</label>
                    </div>
                    <!-- Add a Select All/Unselect All Option -->
                    <div class="dropdown-item">
                        <input type="checkbox" id="selectAll"> 
                        <label for="selectAll">Select All</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="dropdown-item">
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Display Selected Options -->
        <div class="selected-options">
            <p><strong>Selected Options:</strong></p>
            <ul id="selectedOptionsList">
                <!-- Selected options will appear here -->
            </ul>
        </div>
    </div>

    <!-- jQuery, Bootstrap JS, and custom script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {

            // Toggle select/unselect all options
            $('#selectAll').on('change', function () {
                const isChecked = $(this).prop('checked');
                $('#multiSelectForm input[type="checkbox"]').prop('checked', isChecked);
                updateSelectedOptions();
            });

            // Update selected options when checkboxes are clicked
            $('#multiSelectForm input[type="checkbox"]').on('change', function () {
                updateSelectedOptions();
            });

            // Function to update the selected options list
            function updateSelectedOptions() {
                const selectedOptions = [];
                $('#multiSelectForm input[type="checkbox"]:checked').each(function () {
                    selectedOptions.push($(this).next('label').text());
                });

                // Clear the previous selected options
                $('#selectedOptionsList').empty();

                // Append the selected options to the list
                if (selectedOptions.length > 0) {
                    selectedOptions.forEach(function (option) {
                        $('#selectedOptionsList').append('<li>' + option + '</li>');
                    });
                } else {
                    $('#selectedOptionsList').append('<li>No options selected</li>');
                }
            }
        });
    </script>
</body>
</html>
