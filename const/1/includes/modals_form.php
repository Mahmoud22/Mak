<!-- Modal for adding a new account -->
<div class="modal fade" id="wideModalAdd" tabindex="-1" role="dialog" aria-labelledby="wideModalLabelAdd">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" dir="rtl">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="wideModalLabelAdd">إضافة حساب جديد</h3>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <form method="POST" action="insert_form.php" id="dynamicForm">
                    
                    <!-- Client and Project Input Fields -->
                    <div class="form-row">
                        <div class="form-group col-12 col-md-6">
                            <label for="client" class="font-weight-bold">العميل</label>
                            <input type="text" id="client" name="client" class="form-control" placeholder="أدخل اسم العميل">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="project" class="font-weight-bold">المشروع</label>
                            <input type="text" id="project" name="project" class="form-control" placeholder="أدخل اسم المشروع">
                        </div>
                    </div>
                    
                    <!-- Length, Width, Height Inputs -->
                    <div class="form-row">
                        <div class="form-group col-12 col-md-4">
                            <label for="length" class="font-weight-bold">الطول</label>
                            <input type="number" id="length" name="length" class="form-control">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="width" class="font-weight-bold">العرض</label>
                            <input type="number" id="width" name="width" class="form-control">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="height" class="font-weight-bold">الإرتفاع</label>
                            <input type="number" id="height" name="height" class="form-control">
                        </div>
                    </div>

                    <!-- Unit Selection -->
                    <div class="form-group">
                        <label for="unit" class="font-weight-bold">اختر الوحدة</label>
                        <select id="unit" name="unit" class="form-control">
                            <option value="">اختر وحدة</option>
                            <?php
                            if (isset($unitOptions) && is_array($unitOptions)) {
                                foreach ($unitOptions as $option) {
                                    echo '<option value="' . $option['value'] . '">' . $option['type'] . ' - ' . $option['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
					
					
                    <!-- Categories Section -->
                    <div class="categories mt-4">
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
						
<!-- Media Upload Section -->
<div class="form-group">
    <label class="font-weight-bold">التقاط صورة أو اختيار من المعرض</label>
    <input type="file" id="photoUpload" name="photo" accept="image/*" class="form-control d-none">
    <button type="button" class="btn btn-modern-primary" onclick="handleFileInput('photoUpload', 'photo')">اختر صورة</button>
</div>

<div class="form-group">
    <label class="font-weight-bold">تسجيل فيديو أو اختيار من المعرض</label>
    <input type="file" id="videoUpload" name="video" accept="video/*" class="form-control d-none">
    <button type="button" class="btn btn-modern-primary" onclick="handleFileInput('videoUpload', 'video')">اختر فيديو</button>
</div>
      </div>

				
                </form>

                <!-- Buttons -->
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-modern-primary" data-dismiss="modal" aria-label="Close">إلغاء</button>
                    <button type="submit" id="saveDataBtn" class="btn btn-modern-success">حفظ البيانات</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Close modal function and move focus
    function closeModal() {
        document.getElementById('wideModalAdd').style.display = 'none';
        document.getElementById('cameraPhotoBtn').focus();  // Move focus to the camera button or any other element
    }
</script>

<!-- JavaScript to handle camera functionality -->
<script>
let videoStream = null;
let mediaRecorder = null;
let recordedChunks = [];

// Start Camera Function
function startCamera(mode) {
    const videoElement = document.getElementById('video');
    const canvasElement = document.getElementById('canvas');
    const photoInput = document.getElementById('photoUpload');
    const videoInput = document.getElementById('videoUpload');

    // Check if getUserMedia is supported
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                videoStream = stream;
                videoElement.style.display = 'block';
                videoElement.srcObject = stream;
                videoElement.play();

                if (mode === 'photo') {
                    // Capture Photo
                    document.getElementById('cameraPhotoBtn').onclick = function () {
                        capturePhoto(videoElement, canvasElement, photoInput);
                    };
                } else if (mode === 'video') {
                    // Record Video
                    startRecording(videoElement);
                }
            })
            .catch(handleCameraError);
    } else {
        alert("Camera access is not supported in this browser. Please use a modern browser such as Chrome or Firefox.");
    }
}

// Capture Photo
function capturePhoto(videoElement, canvasElement, photoInput) {
    const context = canvasElement.getContext('2d');
    canvasElement.width = videoElement.videoWidth;
    canvasElement.height = videoElement.videoHeight;
    context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);

    // Convert canvas to image data
    const imageData = canvasElement.toDataURL('image/png');
    const blob = dataURItoBlob(imageData);

    // Create a file object
    const file = new File([blob], "photo.png", { type: "image/png" });
    photoInput.files = createFileList(file);

    alert("Photo captured!");
}

// Start Video Recording
function startRecording(videoElement) {
    recordedChunks = [];
    mediaRecorder = new MediaRecorder(videoStream);

    mediaRecorder.ondataavailable = function (event) {
        if (event.data.size > 0) {
            recordedChunks.push(event.data);
        }
    };

    mediaRecorder.onstop = function () {
        const blob = new Blob(recordedChunks, { type: "video/webm" });
        const videoInput = document.getElementById('videoUpload');
        const file = new File([blob], "video.webm", { type: "video/webm" });
        videoInput.files = createFileList(file);

        alert("Video recorded!");
    };

    mediaRecorder.start();
    alert("Recording started!");

    // Stop recording after 10 seconds for demonstration
    setTimeout(() => {
        mediaRecorder.stop();
        alert("Recording stopped!");
    }, 10000);
}

// Utility: Convert Data URI to Blob
function dataURItoBlob(dataURI) {
    const byteString = atob(dataURI.split(',')[1]);
    const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    const arrayBuffer = new ArrayBuffer(byteString.length);
    const uint8Array = new Uint8Array(arrayBuffer);
    for (let i = 0; i < byteString.length; i++) {
        uint8Array[i] = byteString.charCodeAt(i);
    }
    return new Blob([arrayBuffer], { type: mimeString });
}

// Utility: Create FileList
function createFileList(file) {
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    return dataTransfer.files;
}

// Handle Camera Errors
function handleCameraError(error) {
    console.error("Camera Error: ", error);
    alert("Error accessing the camera: " + error.message);
}
	
	function handleFileInput(inputId, type) {
    const userChoice = confirm(`Do you want to ${type === 'photo' ? 'capture a photo' : 'record a video'} or choose from the gallery?`);

    if (userChoice) {
        // Force the camera
        document.getElementById(inputId).setAttribute('capture', 'environment');
    } else {
        // Allow gallery selection
        document.getElementById(inputId).removeAttribute('capture');
    }

    document.getElementById(inputId).click();
}

	
</script>



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