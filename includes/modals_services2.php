<!-- Add Project Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="projectModalLabel">إضافة مشروع جديد</h4>
            </div>
            <div class="modal-body">
                <form id="addProjectForm" method="POST" action="insert_update_project.php">
                    <input type="hidden" id="projectId" name="projectId">
                    <div class="form-group">
                        <label for="clientSelect">العميل</label>
                        <select id="addClientSelect" name="client_id" class="form-control" required>
                            <option value="">اختر العميل</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="projectName">اسم المشروع</label>
                        <input type="text" id="projectName" name="project_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="license">رقم رخصة البناء</label>
                        <input type="text" id="license" name="license" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">العنوان</label>
                        <input type="text" id="address" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="startwork">تاريخ بداية العمل</label>
                        <input type="date" id="startwork" name="startwork" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="endwork">تاريخ الإنتهاء من العمل</label>
                        <input type="date" id="endwork" name="endwork" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitBtn">ارسال</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editProjectModalLabel">تعديل المشروع</h4>
            </div>
            <div class="modal-body">
                <form id="editProjectForm" method="POST">
                    <input type="hidden" id="editProjectId" name="id">
                    <div class="form-group">
                        <label for="editClientSelect">العميل</label>
                        <select id="editClientSelect" name="client_id" class="form-control" required>
                            <option value="">اختر العميل</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editProjectName">اسم المشروع</label>
                        <input type="text" id="editProjectName" name="project_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editLicense">رقم رخصة البناء</label>
                        <input type="text" id="editLicense" name="license" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">العنوان</label>
                        <input type="text" id="editAddress" name="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editStartwork">تاريخ بداية العمل</label>
                        <input type="date" id="editStartwork" name="startwork" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editEndwork">تاريخ الإنتهاء من العمل</label>
                        <input type="date" id="editEndwork" name="endwork" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h4>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد أنك تريد حذف هذا المشروع؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger" id="deleteBtn">حذف</button>
            </div>
        </div>
    </div>
</div>
