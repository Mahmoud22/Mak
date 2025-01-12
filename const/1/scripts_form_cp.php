<script>
$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const clientId = urlParams.get('client_id');
    const projectId = urlParams.get('project_id');
    
    console.log("Client ID from URL:", clientId);
    console.log("Project ID from URL:", projectId);
    
    // Set these values in the modal or form fields
    $('#client').val(clientId);
    $('#project').val(projectId);
});

// Initialize Select2 for unit dropdown
$('#unit').select2({
    width: '100%' // Ensure full width for dropdown
});

// Open the modal and set values
$(document).on('click', '.openModal', function () {
    const client = $(this).data('client') || clientId; 
    const project = $(this).data('project') || projectId; 
    const unit = $(this).data('unit');
    const length = $(this).data('length');
    const width = $(this).data('width');
    const height = $(this).data('height');

    $('#client').val(client);
    $('#project').val(project);
    $('#unit').val(unit).trigger('change');
    $('#length').val(length);
    $('#width').val(width);
    $('#height').val(height);

    $('.form-row').show();
});

// Show quantity input for selected services based on type_account
$(document).on('change', '.service-checkbox', function () {
    const $serviceItem = $(this).closest('.service-item');
    const $quantityInput = $serviceItem.find('.service-quantity');
    const accountType = $serviceItem.find('.service-type-account').val();

    if ($(this).is(':checked')) {
        if (accountType === 'م2') {
            const length = parseFloat($('#length').val()) || 0;
            const width = parseFloat($('#width').val()) || 0;
            const height = parseFloat($('#height').val()) || 0;
            const total = length * width * height;

            $quantityInput.val(total.toFixed(2));
            $quantityInput.prop('readonly', true).show();
        } else {
            $quantityInput.val('').prop('readonly', false).show();
        }
    } else {
        $quantityInput.hide().val('');
    }
});

// Fetch services for categories dynamically when clicked
$(document).on('click', '.category-header', function () {
    const category = $(this).text().trim(); 
    const $servicesContainer = $(this).next('.services-container'); 

    if (!$servicesContainer.hasClass('loaded')) {
        $.ajax({
            url: 'get_services.php',
            method: 'GET',
            data: { category },
            dataType: 'json',
            success: function (services) {
                if (services && services.length > 0) {
                    const servicesHTML = services.map(service => `  
                        <div class="service-item">
                            <input type="checkbox" class="service-checkbox" data-service-id="${service.id}" />
                            ${service.type} - ${service.name}
                            <input type="hidden" class="service-price" value="${service.price}" />
                            <input type="hidden" class="service-type-account" value="${service.type_account}" />
                            <input type="number" class="service-quantity" placeholder="الكمية" style="display: none;" />
                        </div>
                    `).join(''); 
                    $servicesContainer.html(servicesHTML).addClass('loaded').show();
                } else {
                    $servicesContainer.html('<p>لا توجد خدمات لهذا التصنيف.</p>').show();
                }
            },
            error: function () {
                alert('فشل في جلب الخدمات.');
            }
        });
    } else {
        $servicesContainer.toggle(); 
    }
});

// Collect and save data on form submission
$('#saveDataBtn').on('click', function (event) {
    event.preventDefault();

    const client = $('#client').val() || clientId; 
    const project = $('#project').val() || projectId; 
    const unit = $('#unit').val();
    const length = $('#length').val();
    const width = $('#width').val();
    const height = $('#height').val();

    // Collect file data (photo and video)
    const photoFile = $('#photoUpload')[0].files[0]; // First file in the photo input
    const videoFile = $('#videoUpload')[0].files[0]; // First file in the video input

    let unitsData = [];
    $('.category-item').each(function () {
        const categoryName = $(this).find('.category-header').text().trim();
        const services = [];

        $(this).find('.service-checkbox:checked').each(function () {
            const serviceId = $(this).data('service-id');
            const quantity = $(this).closest('.service-item').find('.service-quantity').val();
            const price = $(this).closest('.service-item').find('.service-price').val();
            const accountType = $(this).closest('.service-item').find('.service-type-account').val();

            if (serviceId && quantity && price && accountType) {
                services.push({
                    serviceId,
                    quantity: parseInt(quantity),
                    price: parseFloat(price),
                    accountType
                });
            }
        });

        if (services.length > 0) {
            unitsData.push({
                category: categoryName,
                services
            });
        }
    });

    if (unitsData.length > 0) {
        const formData = new FormData();
        formData.append('client_id', client); // Add client_id explicitly
        formData.append('project_id', project); // Add project_id explicitly
        formData.append('unit', unit);
        formData.append('length', length);
        formData.append('width', width);
        formData.append('height', height);
        formData.append('unitsData', JSON.stringify(unitsData)); // Convert unitsData to JSON

        // Append file data if available
        if (photoFile) {
            formData.append('photo', photoFile);
        }

        if (videoFile) {
            formData.append('video', videoFile);
        }

        // Log FormData content before submitting
        console.log('Form data before sending:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Submit data via AJAX
        $.ajax({
            url: 'insert_form_pc.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log('Server response:', response);
                if (response.status === "success") {
                    alert('تمت إضافة البيانات بنجاح!');
                    window.location.href = 'form_cp.php?client_id=' + client;
                } else {
                    alert('فشل في إرسال البيانات: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error response:', xhr.responseText);
                alert('فشل في إرسال البيانات.');
            }
        });
    } else {
        alert('يرجى تحديد الخدمات قبل إرسال البيانات.');
    }
});

// Toggle details rows with عرض/إخفاء functionality
$(document).on('click', '.collapse-btn', function () {
    var target = $(this).data('target'); // Get the target row ID
    $(target).toggle(); // Toggle the visibility of the row

    // Update the button text
    var currentText = $(this).text().trim(); // Trim extra whitespace
    var btnText = currentText === "عرض" ? "إخفاء" : "عرض"; // Toggle between "عرض" and "إخفاء"
    $(this).text(btnText); // Update the button text
});

// Edit Button Handling for Populating Modal
$(document).on('click', '.editBtn', function () {
    // Log data attributes for debugging
    const dataAttributes = {
        clientId: $(this).data('client_id'),
        projectId: $(this).data('project_id'),
        unitId: $(this).data('g_category_id'),
        length: $(this).data('length'),
        width: $(this).data('width'),
        height: $(this).data('height'),
        totalArea: $(this).data('total_area'),
    };
    console.log(dataAttributes);

    // Retrieve data attributes
    const clientId = dataAttributes.clientId || '';
    const projectId = dataAttributes.projectId || '';
    const unitId = dataAttributes.unitId && dataAttributes.unitId !== 'N/A' ? dataAttributes.unitId : '';
    const length = dataAttributes.length || '0.00';
    const width = dataAttributes.width || '0.00';
    const height = dataAttributes.height || '0.00';
    const totalArea = dataAttributes.totalArea || '0.00';

    // Populate modal fields
    $('#clientId').val(clientId);
    $('#projectId').val(projectId);
    $('#client').val(clientId); // Display client name if necessary
    $('#project').val(projectId); // Display project name if necessary

    if (unitId) {
        $('#unit').val(unitId).trigger('change'); // Ensure dropdown reflects the correct selection
    } else {
        alert('يرجى اختيار الوحدة الصحيحة'); // Alert if unitId is invalid
        $('#unit').val('').trigger('change'); // Reset dropdown if invalid
    }

    $('#length').val(length);
    $('#width').val(width);
    $('#height').val(height);
    $('#total_area').val(totalArea);

    // Show the update modal
    $('#updateModal').modal('show');
});

// Automatically calculate the total area when dimensions change
document.addEventListener('DOMContentLoaded', function () {
    const lengthInput = document.getElementById('length');
    const widthInput = document.getElementById('width');
    const heightInput = document.getElementById('height');
    const totalAreaInput = document.getElementById('total_area');

    function updateTotalArea() {
        const length = parseFloat(lengthInput.value) || 0;
        const width = parseFloat(widthInput.value) || 0;
        const height = parseFloat(heightInput.value) || 0;
        totalAreaInput.value = (length * width * height).toFixed(2); // Round to 2 decimal places
    }

    [lengthInput, widthInput, heightInput].forEach(input => {
        input.addEventListener('input', updateTotalArea); // Recalculate on input change
    });
});

// Delete button handling
$(document).on('click', '.deleteBtn', function () {
    const operationId = $(this).data('id');
    if (confirm('انت بصدد حذف البيانات. هل تود الإستمرار؟')) {
        $.ajax({
            url: 'form_delete.php',
            type: 'POST',
            data: { id: operationId },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload(); // Reload the page after deletion
                } else {
                    alert(data.message || 'خطاء اثناء عملية الحذف');
                }
            },
            error: function () {
                alert('An error occurred while trying to delete the operation.');
            }
        });
    }
});
</script>

<script>
    document.querySelectorAll('.show-media').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            var mediaType = this.getAttribute('data-media-type');
            var mediaPath = this.getAttribute('data-media-path');
            var mediaContent = document.getElementById('mediaContent');
            
            if (mediaType === 'photo') {
                mediaContent.innerHTML = '<img src="' + mediaPath + '" alt="Photo" style="max-width: 100%; max-height: 400px;">';
            } else if (mediaType === 'video') {
                mediaContent.innerHTML = '<video controls style="max-width: 100%; max-height: 400px;">' +
                                         '<source src="' + mediaPath + '" type="video/mp4">' +
                                         'Your browser does not support the video tag.' +
                                         '</video>';
            }

            // Show the modal
            $('#mediaModal').modal('show');
        });
    });
</script>
