 <!-- Insert Modal -->
  <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="insertModalLabel">إضافة خدمة جديدة</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="services_action.php" method="post">
            <div class="form-group">
              <label for="name">نوع الخدمة</label>
              <select class="form-control" id="type" name="type" required placeholder="نوع اسم الخدمة">
                <option>-- اختر من القائمة --</option>
                <option value="دهانات">دهانات</option>
                <option value="بلاط">بلاط</option>
                <option value="بناء">بناء</option>
                <option value="هد/إزالة">هد/إزالة</option>
                <option value="لياسة">لياسة</option>
                <option value="جبس">جبس</option>
                <option value="شبابيك">شبابيك</option>
                <option value="أبواب">أبواب</option>
                <option value="عوازل">عوازل</option>
                <option value="سباكة">سباكة</option>
                <option value="أخرى">أخرى</option>
              </select>
            </div>
            <div class="form-group">
              <label for="name">اسم الخدمة</label>
              <input type="text" class="form-control" id="name" name="name" required placeholder="أدخل اسم الخدمة">
            </div>
            <div class="form-group">
              <label for="name">السعر</label>
              <input type="text" class="form-control" id="price" name="price" required placeholder="أدخل السعر">
            </div>
			   <div class="form-group">
              <label for="name">طريقة الحساب</label>
              <select class="form-control" id="type_account" name="type_account" required placeholder="طريقة الحساب">
                <option>-- اختر من القائمة --</option>
                <option value="عدد">عدد</option>
                <option value="م2">م2</option>
				<option value="م ط">م ط</option>
				<option value="مقطوع">مقطوع</option>
				<option value="درجة">درجة</option>
				<option value="حبة">حبة</option>
				<option value="موقع">موقع</option>
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
          <button type="submit" class="btn btn-primary">إضافة</button>
        </div>
          </form>
      </div>
    </div>
  </div>

 <!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">تعديل الخدمة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="services_update.php" method="POST" id="updateForm">
                    <input type="hidden" name="id" id="updateid"> <!-- Hidden input for category ID -->
                    <div class="form-group">
                      <label for="updateType">نوع الخدمة</label>
                      <select class="form-control" id="updateType" name="type" required placeholder="نوع اسم الخدمة">
                        <option>-- اختر من القائمة --</option>
                        <option value="دهانات">دهانات</option>
                        <option value="بلاط">بلاط</option>
                        <option value="بناء">بناء</option>
                        <option value="هد/إزالة">هد/إزالة</option>
                        <option value="لياسة">لياسة</option>
                        <option value="جبس">جبس</option>
                        <option value="شبابيك">شبابيك</option>
                        <option value="أبواب">أبواب</option>
                        <option value="عوازل">عوازل</option>
                        <option value="سباكة">سباكة</option>
                        <option value="أخرى">أخرى</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="updateName">اسم الخدمة</label>
                        <input type="text" class="form-control" id="updateName" name="name" required placeholder="أدخل اسم الخدمة">
                    </div>
                    <div class="form-group">
                        <label for="updatePrice">السعر</label>
                        <input type="text" class="form-control" id="updatePrice" name="price" required placeholder="ادخل السعر">
                    </div>
					<div class="form-group">
              <label for="updateName">طريقة الحساب</label>
              <select class="form-control" id="updateType_account" name="type_account" required placeholder="طريقة الحساب">
                <option>-- اختر من القائمة --</option>
                <option value="عدد">عدد</option>
                <option value="م2">م2</option>
				<option value="م ط">م ط</option>
				<option value="مقطوع">مقطوع</option>
				<option value="درجة">درجة</option>
				<option value="حبة">حبة</option>
				<option value="موقع">موقع</option>
              </select>
            </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-primary" form="updateForm">تعديل</button>
            </div>
        </div>
    </div>
</div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          هل أنت متأكد أنك تريد حذف هذه الخدمة؟ هذه العملية لا يمكن التراجع عنها.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">تأكيد</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Form for Deleting Item -->
<form action="services_delete.php" method="post" id="deleteForm" style="display:none;">
  <input type="hidden" name="id" id="deleteid">
  <input type="hidden" name="MM_delete" value="deleteForm">
</form>





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

	
	
	</div>