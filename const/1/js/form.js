$(document).ready(function () {
    // Initialize Select2 for dropdowns
    $('#client, #project, #unit').select2();

    // Fetch projects based on selected client
    $('#client').on('change', function () {
        const clientId = $(this).val();
        if (clientId) {
            $.ajax({
                url: 'fetch_data.php',
                method: 'POST',
                data: { client_id: clientId },
                success: function (response) {
                    const projects = JSON.parse(response);
                    $('#project').empty().append('<option value="">اختر المشروع</option>');
                    projects.forEach(project => {
                        $('#project').append(`<option value="${project.id}">${project.project_name}</option>`);
                    });
                    $('#project').select2(); // Reinitialize Select2
                },
                error: function () {
                    alert("فشل في جلب المشاريع. حاول مرة أخرى.");
                }
            });
        } else {
            $('#project').empty().append('<option value="">اختر المشروع</option>').select2();
        }
    });

    // Handle "تقدم" button click
    $('#generateCategoriesBtn').on('click', function () {
        const numRows = $('#inputRow').val().trim();

        // Validate number of rows
        if (!numRows || isNaN(numRows) || numRows <= 0) {
            alert("يرجى إدخال عدد الوحدات السكنية.");
            return;
        }

        $('#dynamicTables').empty(); // Clear previous tables
        generateDynamicTables(numRows);
    });

    // Save data on "حفظ" button click
    $('#saveDataBtn').on('click', function () {
        const operationType = $('input[name="operation"]:checked').val();
        const clientId = $('#client').val();
        const projectId = $('#project').val();
        let unitsData = [];

        if (!operationType || !clientId || !projectId) {
            alert('يرجى اختيار نوع العملية والعميل والمشروع!');
            return;
        }

        $('.unit-fields-container').each(function () {
            const unitId = $(this).find('.unitSelect').val();
            const length = $(this).find(`[name^="L["]`).val() || null;
            const width = $(this).find(`[name^="SH["]`).val() || null;
            const height = $(this).find(`[name^="H["]`).val() || null;
            const totalArea = $(this).find(`[name^="totalArea["]`).val() || null;

            let services = [];

            // Capture selected services and their quantities
            $(this).find('.service-checkbox:checked').each(function () {
                const serviceId = $(this).data('service-id');
                const quantity = $(this).closest('div').find('.service-quantity').val();

                if (serviceId && quantity && !isNaN(quantity) && quantity > 0) {
                    services.push({
                        service_id: serviceId,
                        quantity: parseInt(quantity)
                    });
                }
            });

            console.log("Unit ID:", unitId);
            console.log("Services selected for unit:", services);

            if (unitId) {
                unitsData.push({
                    g_category_id: unitId,
                    length,
                    width,
                    height,
                    total_area: totalArea,
                    services
                });
            }
        });

        if (unitsData.length === 0) {
            alert('يرجى ملء الوحدات السكنية!');
            return;
        }

        const formData = new FormData();
        formData.append('operationType', operationType);
        formData.append('clientId', clientId);
        formData.append('projectId', projectId);
        formData.append('unitsData', JSON.stringify(unitsData));

        $.ajax({
            url: 'insert_form.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                alert('تمت إضافة البيانات بنجاح!');
                window.location.href = 'form.php';
            },
            error: function () {
                alert('خطأ في الاتصال بالخادم.');
            }
        });
    });

    // Fetch services dynamically
    function fetchServices(category) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'get_services.php',
                data: { category },
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(`Fetched services for ${category}:`, data);
                    resolve(data);
                },
                error: function (xhr, status, error) {
                    console.error(`Error fetching services for category ${category}:`, error);
                    reject(error);
                }
            });
        });
    }

    // Escape unsafe HTML characters
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Generate dynamic tables for units
    function generateDynamicTables(numRows) {
        const categories = ['دهانات', 'بلاط', 'بناء', 'هد/إزالة', 'لياسة', 'جبس', 'شبابيك', 'أبواب', 'عوازل', 'سباكة', 'أخرى'];

        for (let i = 0; i < numRows; i++) {
            let unitFieldsHTML = `
                <div class="unit-fields-container" id="unitFields${i + 1}">
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <div>
                            <label>اختر الوحدة:</label>
                            <select class="unitSelect">
                                <option value="">اختر وحدة</option>
                                <?php echo json_encode($unitOptions); ?>
                            </select>
                        </div>
                        <div>
                            <label>الطول:</label>
                            <input type="number" name="L[${i + 1}]" />
                        </div>
                        <div>
                            <label>العرض:</label>
                            <input type="number" name="SH[${i + 1}]" />
                        </div>
                        <div>
                            <label>الإرتفاع:</label>
                            <input type="number" name="H[${i + 1}]" />
                        </div>
                    </div>
                </div>`;

            let tableHTML = `<h3>الوحدة ${i + 1}</h3><table><thead><tr>`;
            categories.forEach(cat => (tableHTML += `<th>${cat}</th>`));
            tableHTML += `</tr></thead><tbody><tr>`;

            // Fetch services and populate the table
            Promise.all(categories.map(fetchServices))
                .then(results => {
                    results.forEach((services, index) => {
                        tableHTML += `<td>`;
                        if (services.length > 0) {
                            services.forEach(service => {
                                console.log(service); // Log to check the service object
                                if (service.id && service.name) {
                                    tableHTML += `
                                        <div>
                                            <input type="checkbox" class="service-checkbox" data-service-id="${service.id}" />
                                            ${service.name}
                                            <input type="number" class="service-quantity" placeholder="الكمية" style="display: none;" />
                                        </div>`;
                                } else {
                                    console.warn(`Invalid service data:`, service); // Log if service data is invalid
                                }
                            });
                        } else {
                            tableHTML += `لا توجد خدمات متوفرة`;
                        }
                        tableHTML += `</td>`;
                    });
                    tableHTML += `</tr></tbody></table>`;
                    $('#dynamicTables').append(unitFieldsHTML + tableHTML);
                })
                .catch(() => alert('خطأ أثناء جلب البيانات.'));
        }
    }

    // Show/hide quantity input based on checkbox state
    $(document).on('change', '.service-checkbox', function () {
        const quantityInput = $(this).closest('div').find('.service-quantity');
        if ($(this).is(':checked')) {
            quantityInput.show();
        } else {
            quantityInput.hide().val('');
        }
    });
});




    $(document).ready(function () {
        // Update button click
        $(document).on('click', '.updateBtn', function () {
            const rowId = $(this).data('id');
            // Fetch data for the selected row (use AJAX or preloaded data)
            $.ajax({
                url: 'insert_form.php', // Backend script to fetch row details
                type: 'GET',
                data: { id: rowId },
                success: function (data) {
                    // Populate modal with data
                    const record = JSON.parse(data);
                    $('#updateId').val(record.id);
                    $('#updateClient').val(record.client_name);
                    $('#updateProject').val(record.project_name);
                    $('#updateService').val(record.service_name);
                    $('#updateModal').modal('show');
                }
            });
        });

		
        // Delete button click
        $(document).on('click', '.deleteBtn', function () {
            const rowId = $(this).data('id');
            $('#confirmDeleteBtn').data('id', rowId); // Pass ID to delete button
            $('#deleteModal').modal('show');
        });

        // Confirm delete
        $('#confirmDeleteBtn').on('click', function () {
            const rowId = $(this).data('id');
            // Perform delete operation (use AJAX)
            $.ajax({
                url: 'form_delete.php', // Backend script to delete row
                type: 'POST',
                data: { id: rowId },
                success: function (response) {
                    alert('تم حذف السجل بنجاح!');
                    $('#deleteModal').modal('hide');
                    location.reload(); // Reload table
                }
            });
        });

        // Update form submission
        $('#updateForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: 'insert_form.php', // Backend script to update row
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    alert('تم تحديث السجل بنجاح!');
                    $('#updateModal').modal('hide');
                    location.reload(); // Reload table
                }
            });
        });
    });

