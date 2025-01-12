
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">تعديل العملية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateForm">
                <div class="modal-body">
                    <input type="hidden" id="clientId" name="clientId">
                    <input type="hidden" id="projectId" name="projectId">
                    <div class="mb-3">
                        <label for="client" class="form-label">العميل</label>
                        <input type="text" class="form-control" id="client" name="client" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="project" class="form-label">المشروع</label>
                        <input type="text" class="form-control" id="project" name="project" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">الوحدة</label>
                        <select id="unit" name="unit" class="form-control">
                            <option value="">اختر وحدة</option>
                            <?php
                            if (isset($unitOptions) && is_array($unitOptions)) {
                                foreach ($unitOptions as $option) {
                                    echo '<option value="' . $option['value'] . '">' . $option['type'] . ' - ' . $option['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>                    </div>
                    <div class="mb-3">
                        <label for="length" class="form-label">الطول</label>
                        <input type="text" class="form-control" id="length" name="length">
                    </div>
                    <div class="mb-3">
                        <label for="width" class="form-label">العرض</label>
                        <input type="text" class="form-control" id="width" name="width">
                    </div>
                    <div class="mb-3">
                        <label for="height" class="form-label">الارتفاع</label>
                        <input type="text" class="form-control" id="height" name="height">
                    </div>
                    <div class="mb-3">
                        <label for="total_area" class="form-label">المساحة الكلية</label>
                        <input type="text" class="form-control" id="total_area" name="total_area" readonly>
                    </div>
					
					                    <!-- Categories Section -->
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">دهانات</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for دهانات -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">بلاط</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for بلاط -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">بناء</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for بناء -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">هد/إزالة</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for هد/إزالة -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">لياسة</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for لياسة -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">جبس</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for جبس -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">شبابيك</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for شبابيك -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">أبواب</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for أبواب -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">عوازل</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for عوازل -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">سباكة</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for سباكة -->
                            </div>
                        </div>
                        <div class="category-item mb-3">
                            <div class="category-header p-2 bg-primary text-white rounded text-center">أخرى</div>
                            <div class="services-container p-3 bg-light border rounded mt-2">
                                <!-- Sample Inputs for أخرى -->
                            </div>
                        </div>
					
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Additional CSS for Mobile Responsiveness and Modern Button Styles -->
<style>
    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 90%;
        }
        .form-group label {
            font-size: 14px;
        }
        .form-control {
            font-size: 14px;
            padding: 0.5rem;
        }
        .category-header {
            font-size: 16px;
        }
        .category-item {
            margin-bottom: 10px;
        }
        .services-container {
            font-size: 14px;
            padding: 1rem;
        }
    }

    /* Modern Button Styles */
    .btn-modern-primary {
        background: linear-gradient(to right, #4e73df, #224abe); /* Gradient background */
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 30px; /* Rounded corners */
        font-size: 16px;
        text-transform: uppercase;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-modern-primary:hover {
        background: linear-gradient(to right, #224abe, #4e73df);
        transform: translateY(-2px); /* Slight lift effect */
    }

    .btn-modern-success {
        background: linear-gradient(to right, #1cc88a, #28a745); /* Gradient background */
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 30px; /* Rounded corners */
        font-size: 16px;
        text-transform: uppercase;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-modern-success:hover {
        background: linear-gradient(to right, #28a745, #1cc88a);
        transform: translateY(-2px); /* Slight lift effect */
    }
</style>

