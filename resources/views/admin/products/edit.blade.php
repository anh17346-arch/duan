@extends('layouts.app')
@section('title','Sửa sản phẩm - Perfume Luxury')

@section('content')
<!-- Modern Unified Background -->
<div class="min-h-screen relative overflow-hidden">
  <!-- Animated Background -->
  <div class="fixed inset-0 -z-10">
    <!-- Main Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/60 via-purple-50/60 to-pink-50/60 dark:from-slate-900 dark:via-blue-900/30 dark:via-purple-900/30 dark:to-pink-900/30"></div>
    
    <!-- Floating Animated Blobs -->
    <div class="absolute top-20 left-10 w-64 h-64 bg-gradient-to-r from-blue-400/10 to-purple-400/10 dark:from-blue-400/5 dark:to-purple-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob"></div>
    <div class="absolute top-40 right-20 w-72 h-72 bg-gradient-to-r from-pink-400/10 to-rose-400/10 dark:from-pink-400/5 dark:to-rose-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-32 left-1/3 w-80 h-80 bg-gradient-to-r from-cyan-400/10 to-teal-400/10 dark:from-cyan-400/5 dark:to-teal-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-4000"></div>
    <div class="absolute bottom-20 right-1/4 w-56 h-56 bg-gradient-to-r from-emerald-400/10 to-green-400/10 dark:from-emerald-400/5 dark:to-green-400/5 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl animate-blob animation-delay-6000"></div>
    
    <!-- Mesh Gradient Overlay -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)] dark:bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.05),transparent_50%)]"></div>
    
    <!-- Subtle Grid Pattern -->
    <div class="absolute inset-0 bg-[linear-gradient(rgba(100,116,139,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(100,116,139,0.03)_1px,transparent_1px)] bg-[size:64px_64px] dark:bg-[linear-gradient(rgba(148,163,184,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.02)_1px,transparent_1px)]"></div>
  </div>

<div class="relative max-w-4xl mx-auto px-4 py-8">
  <div class="relative mb-8">
    <a href="{{ route('admin.dashboard') }}" 
       class="group absolute left-0 top-1/2 -translate-y-1/2 inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-full hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-110 transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-sm border border-white/50 dark:border-slate-600/50">
      <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
      </svg>
    </a>
    <div class="flex flex-col items-center">
      <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 text-center">Sửa sản phẩm</h1>
      <p class="text-slate-600 dark:text-slate-400 mt-2 text-center">Cập nhật thông tin sản phẩm "{{ $product->name }}"</p>
    </div>
  </div>

  <div class="backdrop-blur-md bg-white/20 dark:bg-white/5 rounded-2xl p-6 shadow-lg border border-white/30 dark:border-white/10">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
      @csrf
      <input type="hidden" name="_method" value="PUT">
      @include('admin.products._form', ['product' => $product, 'categories' => $categories])

      <div class="flex items-center justify-end pt-8">
        <button type="submit" class="group px-8 py-4 bg-gradient-to-r from-brand-600 to-brand-700 hover:from-brand-700 hover:to-brand-800 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-2xl flex items-center gap-3 relative overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
          <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
          <span class="relative z-10">Cập nhật sản phẩm</span>
        </button>
      </div>
    </form>
  </div>


</div>
</div>

<style>
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
  animation: blob 7s infinite;
}
.animation-delay-2000 {
  animation-delay: 2s;
}
.animation-delay-4000 {
  animation-delay: 4s;
}
.animation-delay-6000 {
  animation-delay: 6s;
}
</style>
@endsection

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
// Debug function to test if JS is working
function testImageUploadButton() {
  console.log('Testing image upload button...');
  const button = document.querySelector('button[onclick="openImageUpload()"]');
  console.log('Button found:', button);
  
  const modal = document.getElementById('image-upload-modal');
  console.log('Modal found:', modal);
  
  if (button && modal) {
    console.log('Both button and modal exist, testing openImageUpload function...');
    if (typeof openImageUpload === 'function') {
      console.log('openImageUpload function exists');
      openImageUpload();
    } else {
      console.error('openImageUpload function not found!');
    }
  }
}

// Handle gallery upload when files are selected
function handleGalleryUpload(input) {
  console.log('Gallery files selected:', input.files.length);
  
  const statusDiv = document.getElementById('gallery-upload-status');
  
  if (!input.files || input.files.length === 0) {
    statusDiv.textContent = '';
    return;
  }
  
  // Show selected files info
  let totalSize = 0;
  let fileInfo = [];
  
  Array.from(input.files).forEach((file, index) => {
    totalSize += file.size;
    fileInfo.push(`${file.name} (${(file.size / 1024 / 1024).toFixed(1)}MB)`);
  });
  
  statusDiv.innerHTML = `
    <div class="text-green-600 dark:text-green-400">
      ✅ Đã chọn ${input.files.length} ảnh - Total: ${(totalSize / 1024 / 1024).toFixed(1)}MB
      <br><small class="text-xs">${fileInfo.join(', ')}</small>
      <br><small class="text-xs text-blue-600">💡 Click "Cập nhật sản phẩm" để lưu ảnh gallery</small>
    </div>
  `;
}

// Upload gallery images
async function uploadGalleryImages(files) {
  const statusDiv = document.getElementById('gallery-upload-status');
  const productId = {{ $product->id ?? 'null' }};
  
  statusDiv.textContent = 'Đang upload...';
  
  try {
    // Validate files
    const maxSize = 4 * 1024 * 1024; // 4MB
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      
      if (file.size > maxSize) {
        alert(`Ảnh "${file.name}" quá lớn. Kích thước tối đa: 4MB`);
        statusDiv.textContent = 'Upload bị hủy';
        return;
      }
      
      if (!allowedTypes.includes(file.type)) {
        alert(`Ảnh "${file.name}" không đúng định dạng. Chỉ chấp nhận: JPG, PNG, WEBP`);
        statusDiv.textContent = 'Upload bị hủy';
        return;
      }
    }
    
    // Get CSRF token
    const csrfToken = document.querySelector('input[name="_token"]');
    if (!csrfToken) {
      throw new Error('CSRF token không tìm thấy');
    }
    
    // Create FormData
    const formData = new FormData();
    
    // Add files
    Array.from(files).forEach(file => {
      formData.append('images[]', file);
    });
    
    // Add CSRF token
    formData.append('_token', csrfToken.value);
    
    // Upload
    const response = await fetch(`/admin/products/${productId}/images`, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken.value,
        'Accept': 'application/json'
      }
    });
    
    const data = await response.json();
    
    if (data.success) {
      statusDiv.textContent = `Upload thành công ${files.length} ảnh!`;
      statusDiv.className = 'text-sm text-green-600 dark:text-green-400';
      
      // Reset file input
      document.getElementById('gallery-images').value = '';
      
      // Reload page after 2 seconds to show new images
      setTimeout(() => {
        location.reload();
      }, 2000);
      
    } else {
      throw new Error(data.message || 'Upload thất bại');
    }
    
  } catch (error) {
    console.error('Upload error:', error);
    statusDiv.textContent = `Lỗi: ${error.message}`;
    statusDiv.className = 'text-sm text-red-600 dark:text-red-400';
  }
}

// Gallery functions - Define them here to ensure they're available
function openImageUpload() {
  console.log('Opening image upload modal...');
  const modal = document.getElementById('image-upload-modal');
  if (modal) {
    modal.classList.remove('hidden');
    
    // Focus on file input after a short delay
    setTimeout(() => {
      const fileInput = modal.querySelector('input[type="file"]');
      if (fileInput) {
        fileInput.focus();
      }
    }, 100);
  } else {
    console.error('Modal not found!');
    alert('Lỗi: Không tìm thấy modal upload. Vui lòng refresh trang.');
  }
}

function closeImageUpload() {
  const modal = document.getElementById('image-upload-modal');
  const form = document.getElementById('image-upload-form');
  
  if (modal) {
    modal.classList.add('hidden');
  }
  
  if (form) {
    if (typeof form.reset === 'function') {
      form.reset();
    } else {
      const fileInput = form.querySelector('input[type="file"][name="images[]"]');
      if (fileInput) {
        fileInput.value = '';
      }
    }
  }
}

// Handle image upload
async function uploadImages() {
  try {
    // Kiểm tra xem có phải đang edit sản phẩm không
    const productId = {{ $product->id ?? 'null' }};
    const isEditMode = {{ isset($product) && $product->id ? 'true' : 'false' }};
    
    if (!isEditMode) {
      // Nếu đang tạo mới, cần tạo sản phẩm trước
      const shouldCreateFirst = confirm('Để thêm ảnh phụ, cần tạo sản phẩm trước. Bạn có muốn lưu thông tin sản phẩm và tiếp tục thêm ảnh không?');
      if (!shouldCreateFirst) {
        closeImageUpload();
        return;
      }
      
      // Tự động submit form để tạo sản phẩm
      await saveProductAndContinue();
      return;
    }

    const fileInput = document.querySelector('#image-upload-modal input[name="images[]"]');
    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
      alert('Vui lòng chọn ít nhất một ảnh để upload');
      return;
    }

    // Validate files before upload
    const files = Array.from(fileInput.files);
    const maxSize = 4 * 1024 * 1024; // 4MB
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      
      // Kiểm tra kích thước
      if (file.size > maxSize) {
        alert(`Ảnh thứ ${i + 1} (${file.name}) quá lớn. Kích thước tối đa: 4MB`);
        return;
      }
      
      // Kiểm tra định dạng
      if (!allowedTypes.includes(file.type)) {
        alert(`Ảnh thứ ${i + 1} (${file.name}) không đúng định dạng. Chỉ chấp nhận: JPG, PNG, WEBP`);
        return;
      }
    }

    // Get CSRF token from main form
    const mainForm = document.querySelector('form[method="POST"]');
    const csrfToken = mainForm ? mainForm.querySelector('input[name="_token"]') : null;
    if (!csrfToken || !csrfToken.value) {
      alert('Lỗi: CSRF token không hợp lệ');
      return;
    }

    // Disable upload button to prevent double submission
    const uploadBtn = document.querySelector('button[onclick="uploadImages()"]');
    const originalText = uploadBtn ? uploadBtn.textContent : '';
    if (uploadBtn) {
      uploadBtn.disabled = true;
      uploadBtn.textContent = 'Đang upload...';
    }

    // Create FormData
    const formData = new FormData();
    
    // Add files
    for (let i = 0; i < fileInput.files.length; i++) {
      formData.append('images[]', fileInput.files[i]);
      console.log('Adding file:', fileInput.files[i].name, 'Size:', fileInput.files[i].size, 'Type:', fileInput.files[i].type);
    }
    
    // Add CSRF token
    formData.append('_token', csrfToken.value);

    console.log('Uploading to:', `/admin/products/${productId}/images`);
    console.log('Files count:', fileInput.files.length);
    console.log('CSRF token:', csrfToken.value);

    // Make the fetch request
    const response = await fetch(`/admin/products/${productId}/images`, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken.value,
        'Accept': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    
    if (data.success) {
      let message = data.message;
      if (data.errors && data.errors.length > 0) {
        message += '\n\nMột số ảnh bị lỗi:\n' + data.errors.join('\n');
      }
      alert(message);
      closeImageUpload();
      location.reload();
    } else {
      let errorMessage = data.message || 'Không xác định';
      if (data.errors) {
        // Hiển thị lỗi validation chi tiết
        const errorDetails = [];
        Object.keys(data.errors).forEach(key => {
          if (Array.isArray(data.errors[key])) {
            errorDetails.push(`${key}: ${data.errors[key].join(', ')}`);
          } else {
            errorDetails.push(`${key}: ${data.errors[key]}`);
          }
        });
        if (errorDetails.length > 0) {
          errorMessage += '\n\nChi tiết lỗi:\n' + errorDetails.join('\n');
        }
      }
      alert('Lỗi: ' + errorMessage);
    }
  } catch (error) {
    console.error('Upload error:', error);
    let errorMessage = 'Có lỗi xảy ra khi upload ảnh';
    if (error.message) {
      errorMessage += ': ' + error.message;
    }
    alert(errorMessage);
  } finally {
    // Re-enable upload button
    const uploadBtn = document.querySelector('button[onclick="uploadImages()"]');
    if (uploadBtn) {
      uploadBtn.disabled = false;
      uploadBtn.textContent = 'Upload ảnh';
    }
  }
}

// Delete image function
function deleteImage(imageId) {
  if (!confirm('Bạn có chắc muốn xóa ảnh này?')) {
    return;
  }
  
  try {
    const csrfToken = document.querySelector('input[name="_token"]');
    
    fetch(`/admin/product-images/${imageId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken.value,
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        location.reload();
      } else {
        alert('Lỗi: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Delete error:', error);
      alert('Có lỗi xảy ra khi xóa ảnh');
    });
  } catch (error) {
    alert('Lỗi nghiêm trọng: ' + error.message);
  }
}

// Set primary image function
function setPrimaryImage(imageId) {
  if (!confirm('Bạn có chắc muốn đặt ảnh này làm ảnh chính?')) {
    return;
  }
  
  try {
    const csrfToken = document.querySelector('input[name="_token"]');
    
    fetch(`/admin/product-images/${imageId}/primary`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken.value,
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        location.reload();
      } else {
        alert('Lỗi: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Set primary error:', error);
      alert('Có lỗi xảy ra khi đặt ảnh chính');
    });
  } catch (error) {
    alert('Lỗi nghiêm trọng: ' + error.message);
  }
}

// Test modal open function
function testModalOpen() {
  console.log('Testing modal open...');
  const modal = document.getElementById('image-upload-modal');
  console.log('Modal element:', modal);
  
  if (modal) {
    console.log('Modal classes before:', modal.className);
    modal.classList.remove('hidden');
    console.log('Modal classes after:', modal.className);
    
    document.getElementById('test-output').textContent = 'Modal opened successfully!';
    document.getElementById('test-result').classList.remove('hidden');
  } else {
    document.getElementById('test-output').textContent = 'ERROR: Modal not found!';
    document.getElementById('test-result').classList.remove('hidden');
  }
}

// Test upload with actual files
function testUploadWithFiles() {
  console.log('Testing upload with actual files...');
  
  const fileInput = document.getElementById('test-file-input');
  const testOutput = document.getElementById('test-output');
  const testResult = document.getElementById('test-result');
  
  testResult.classList.remove('hidden');
  testOutput.textContent = 'Starting test upload...\n';
  
  if (!fileInput.files || fileInput.files.length === 0) {
    testOutput.textContent += 'ERROR: No files selected!\nPlease select one or more images first.';
    return;
  }
  
  testOutput.textContent += `Files selected: ${fileInput.files.length}\n`;
  
  // Log file info
  Array.from(fileInput.files).forEach((file, index) => {
    testOutput.textContent += `File ${index + 1}: ${file.name} (${file.size} bytes, ${file.type})\n`;
  });
  
  const productId = {{ $product->id ?? 'null' }};
  testOutput.textContent += `Product ID: ${productId}\n`;
  
  // Get CSRF token
  const csrfToken = document.querySelector('input[name="_token"]');
  if (!csrfToken) {
    testOutput.textContent += 'ERROR: CSRF token not found!\n';
    return;
  }
  
  testOutput.textContent += `CSRF token: ${csrfToken.value.substring(0, 10)}...\n`;
  
  // Create FormData
  const formData = new FormData();
  
  // Add files
  Array.from(fileInput.files).forEach(file => {
    formData.append('images[]', file);
  });
  
  // Add CSRF token
  formData.append('_token', csrfToken.value);
  
  testOutput.textContent += 'Sending request...\n';
  
  // Send request
  fetch(`/admin/products/${productId}/images`, {
    method: 'POST',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken.value,
      'Accept': 'application/json'
    }
  })
  .then(response => {
    testOutput.textContent += `Response status: ${response.status}\n`;
    return response.text();
  })
  .then(text => {
    testOutput.textContent += `Response text: ${text}\n`;
    
    try {
      const data = JSON.parse(text);
      testOutput.textContent += `Parsed JSON:\n${JSON.stringify(data, null, 2)}\n`;
      
      if (data.success) {
        testOutput.textContent += 'SUCCESS! Upload completed.\n';
        testOutput.textContent += 'Reloading page in 3 seconds...\n';
        setTimeout(() => location.reload(), 3000);
      } else {
        testOutput.textContent += `UPLOAD FAILED: ${data.message}\n`;
      }
    } catch (e) {
      testOutput.textContent += `Failed to parse JSON: ${e.message}\n`;
    }
  })
  .catch(error => {
    testOutput.textContent += `Request error: ${error.message}\n`;
    console.error('Upload error:', error);
  });
}

// Test form submission data
function testFormSubmission() {
  console.log('Testing form submission data...');
  
  const testOutput = document.getElementById('test-output');
  const testResult = document.getElementById('test-result');
  
  testResult.classList.remove('hidden');
  testOutput.textContent = 'Checking form data...\n';
  
  const mainForm = document.querySelector('form[method="POST"]');
  const galleryInput = document.getElementById('gallery-images');
  
  if (!mainForm) {
    testOutput.textContent += 'ERROR: Main form not found!\n';
    return;
  }
  
  if (!galleryInput) {
    testOutput.textContent += 'ERROR: Gallery input not found!\n';
    return;
  }
  
  testOutput.textContent += `Main form found: ${mainForm.tagName}\n`;
  testOutput.textContent += `Form action: ${mainForm.action}\n`;
  testOutput.textContent += `Form method: ${mainForm.method}\n`;
  testOutput.textContent += `Form enctype: ${mainForm.enctype}\n`;
  testOutput.textContent += `Gallery input in form: ${mainForm.contains(galleryInput)}\n`;
  testOutput.textContent += `Gallery input files: ${galleryInput.files.length}\n`;
  
  if (galleryInput.files.length > 0) {
    testOutput.textContent += '\nGallery files:\n';
    Array.from(galleryInput.files).forEach((file, index) => {
      testOutput.textContent += `  ${index + 1}. ${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)\n`;
    });
  } else {
    testOutput.textContent += '\nNo gallery files selected. Please select some files first.\n';
  }
  
  // Test FormData
  const formData = new FormData(mainForm);
  testOutput.textContent += '\nFormData entries:\n';
  let hasGalleryFiles = false;
  
  for (const [key, value] of formData.entries()) {
    if (key === 'gallery_images[]') {
      hasGalleryFiles = true;
      testOutput.textContent += `  ${key}: ${value.name} (${(value.size / 1024 / 1024).toFixed(2)}MB)\n`;
    } else if (typeof value === 'string') {
      testOutput.textContent += `  ${key}: ${value.substring(0, 50)}${value.length > 50 ? '...' : ''}\n`;
    } else {
      testOutput.textContent += `  ${key}: [File] ${value.name}\n`;
    }
  }
  
  if (!hasGalleryFiles) {
    testOutput.textContent += '\n❌ No gallery_images[] found in FormData!\n';
  } else {
    testOutput.textContent += '\n✅ Gallery files found in FormData!\n';
  }
}

// Test real form submission
function testRealSubmit() {
  console.log('Testing real form submission...');
  
  const testOutput = document.getElementById('test-output');
  const testResult = document.getElementById('test-result');
  
  testResult.classList.remove('hidden');
  testOutput.textContent = 'Testing real submission...\n';
  
  const galleryInput = document.getElementById('gallery-images');
  
  if (!galleryInput || galleryInput.files.length === 0) {
    testOutput.textContent += 'ERROR: Please select gallery images first!\n';
    return;
  }
  
  testOutput.textContent += `Selected ${galleryInput.files.length} files:\n`;
  Array.from(galleryInput.files).forEach((file, index) => {
    testOutput.textContent += `  ${index + 1}. ${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)\n`;
  });
  
  const mainForm = document.querySelector('form[method="POST"]');
  const formData = new FormData(mainForm);
  
  testOutput.textContent += '\nSubmitting to backend...\n';
  
  fetch(mainForm.action, {
    method: 'POST',
    body: formData,
    headers: {
      'Accept': 'application/json'
    }
  })
  .then(response => {
    testOutput.textContent += `Response status: ${response.status}\n`;
    return response.text();
  })
  .then(text => {
    testOutput.textContent += `Response:\n${text}\n`;
    
    // If successful, redirect might occur
    if (text.includes('admin/products')) {
      testOutput.textContent += '\n✅ Success! Check Laravel logs for details.\n';
    }
  })
  .catch(error => {
    testOutput.textContent += `Error: ${error.message}\n`;
    console.error('Test submit error:', error);
  });
}

// Test gallery endpoint specifically
function testGalleryEndpoint() {
  console.log('Testing gallery endpoint...');
  
  const testOutput = document.getElementById('test-output');
  const testResult = document.getElementById('test-result');
  
  testResult.classList.remove('hidden');
  testOutput.textContent = 'Testing gallery endpoint...\n';
  
  const galleryInput = document.getElementById('gallery-images');
  
  if (!galleryInput || galleryInput.files.length === 0) {
    testOutput.textContent += 'ERROR: Please select gallery images first!\n';
    return;
  }
  
  testOutput.textContent += `Selected ${galleryInput.files.length} files:\n`;
  Array.from(galleryInput.files).forEach((file, index) => {
    testOutput.textContent += `  ${index + 1}. ${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)\n`;
  });
  
  const formData = new FormData();
  
  // Add CSRF token
  const csrfToken = document.querySelector('input[name="_token"]');
  if (csrfToken) {
    formData.append('_token', csrfToken.value);
  }
  
  // Add gallery files
  Array.from(galleryInput.files).forEach(file => {
    formData.append('gallery_images[]', file);
  });
  
  testOutput.textContent += '\nSending to test endpoint...\n';
  
  fetch('/admin/test-gallery-upload', {
    method: 'POST',
    body: formData,
    headers: {
      'Accept': 'application/json'
    }
  })
  .then(response => {
    testOutput.textContent += `Response status: ${response.status}\n`;
    return response.json();
  })
  .then(data => {
    testOutput.textContent += `Response data:\n${JSON.stringify(data, null, 2)}\n`;
    
    if (data.success) {
      testOutput.textContent += '\n✅ Test endpoint works! Check Laravel logs.\n';
    } else {
      testOutput.textContent += '\n❌ Test endpoint failed!\n';
    }
  })
  .catch(error => {
    testOutput.textContent += `Error: ${error.message}\n`;
    console.error('Test endpoint error:', error);
  });
}

// Test product images in database
function testProductImages() {
  console.log('Testing product images...');
  
  const testOutput = document.getElementById('test-output');
  const testResult = document.getElementById('test-result');
  
  testResult.classList.remove('hidden');
  testOutput.textContent = 'Checking product images in database...\n';
  
  const productId = {{ $product->id ?? 'null' }};
  testOutput.textContent += `Product ID: ${productId}\n`;
  
  fetch(`/admin/test-product-images/${productId}`)
  .then(response => response.json())
  .then(data => {
    testOutput.textContent += `\nProduct: ${data.product_name}\n`;
    testOutput.textContent += `Images count: ${data.images_count}\n`;
    
    if (data.images && data.images.length > 0) {
      testOutput.textContent += '\nImages found:\n';
      data.images.forEach((img, index) => {
        testOutput.textContent += `  ${index + 1}. ID: ${img.id}, Path: ${img.path}\n`;
        testOutput.textContent += `     URL: ${img.url}\n`;
        testOutput.textContent += `     Primary: ${img.is_primary ? 'Yes' : 'No'}\n`;
      });
      
      testOutput.textContent += '\n✅ Images found in database!';
      testOutput.textContent += '\n💡 If images not showing in UI, try refreshing the page.';
    } else {
      testOutput.textContent += '\n❌ No images found in database!';
    }
  })
  .catch(error => {
    testOutput.textContent += `\nError: ${error.message}`;
    console.error('Test product images error:', error);
  });
}

// Test database constraints
function testDbConstraints() {
  console.log('Testing database constraints...');
  
  const testOutput = document.getElementById('test-output');
  const testResult = document.getElementById('test-result');
  
  testResult.classList.remove('hidden');
  testOutput.textContent = 'Checking database constraints...\n';
  
  fetch('/admin/test-db-constraints')
  .then(response => response.json())
  .then(data => {
    testOutput.textContent += `Constraints found: ${data.constraints_found}\n`;
    
    if (data.constraints && data.constraints.length > 0) {
      testOutput.textContent += '\n❌ PROBLEM: unique_primary_image constraint still exists!\n';
      testOutput.textContent += 'This is causing the gallery upload error.\n';
      testOutput.textContent += '\nConstraint details:\n';
      data.constraints.forEach((constraint, index) => {
        testOutput.textContent += `  ${index + 1}. ${JSON.stringify(constraint)}\n`;
      });
      
      testOutput.textContent += '\n💡 Solution: Run migration to remove constraint\n';
      testOutput.textContent += 'php artisan migrate:rollback --step=1\n';
      testOutput.textContent += 'php artisan migrate\n';
    } else {
      testOutput.textContent += '\n✅ GOOD: No unique_primary_image constraint found!\n';
      testOutput.textContent += 'The constraint has been successfully removed.\n';
    }
    
    if (data.table_structure) {
      testOutput.textContent += '\nTable structure:\n';
      data.table_structure.forEach((column, index) => {
        testOutput.textContent += `  ${index + 1}. ${column.Field} - ${column.Type} - ${column.Null} - ${column.Key}\n`;
      });
    }
  })
  .catch(error => {
    testOutput.textContent += `\nError: ${error.message}`;
    console.error('Test DB constraints error:', error);
  });
}

// Test upload function directly
function testDirectUpload() {
  console.log('Testing direct upload...');
  
  // Create a test FormData
  const formData = new FormData();
  
  // Add CSRF token
  const csrfToken = document.querySelector('input[name="_token"]');
  if (csrfToken) {
    formData.append('_token', csrfToken.value);
    console.log('CSRF token added:', csrfToken.value);
  } else {
    console.error('No CSRF token found!');
    return;
  }
  
  const productId = {{ $product->id ?? 'null' }};
  console.log('Product ID:', productId);
  
  // Test the endpoint
  fetch(`/admin/products/${productId}/images`, {
    method: 'POST',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken.value,
      'Accept': 'application/json'
    }
  })
  .then(response => {
    console.log('Response status:', response.status);
    return response.text();
  })
  .then(text => {
    console.log('Response text:', text);
    try {
      const data = JSON.parse(text);
      console.log('Response JSON:', data);
    } catch (e) {
      console.log('Not JSON response');
    }
  })
  .catch(error => {
    console.error('Test upload error:', error);
  });
}


</script>
<script>
// Auto Translation Functions
async function translateText(text, targetLang) {
  try {
    const response = await fetch('/api/translation/auto-translate', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        text: text,
        target_lang: targetLang
      })
    });

    const data = await response.json();
    
    if (data.success) {
      return data.translated;
    } else {
      throw new Error('Translation failed');
    }
  } catch (error) {
    console.error('Translation error:', error);
    alert('Lỗi dịch văn bản. Vui lòng thử lại.');
    return text;
  }
}

// Auto-translate name
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('translate-name-btn')?.addEventListener('click', async function() {
    const vietnameseName = document.querySelector('input[name="name"]').value;
    
    if (!vietnameseName.trim()) {
      alert('Vui lòng nhập tên sản phẩm tiếng Việt trước.');
      return;
    }

    this.textContent = '🔄 Đang dịch...';
    this.disabled = true;

    try {
      const translatedName = await translateText(vietnameseName, 'en');
      document.getElementById('name_en').value = translatedName;
    } finally {
      this.textContent = '🌐 Auto Translate';
      this.disabled = false;
    }
  });

  // Auto-translate description
  document.getElementById('translate-desc-btn')?.addEventListener('click', async function() {
    const vietnameseDesc = document.getElementById('description').value;
    
    if (!vietnameseDesc.trim()) {
      alert('Vui lòng nhập mô tả tiếng Việt trước.');
      return;
    }

    this.textContent = '🔄 Đang dịch...';
    this.disabled = true;

    try {
      const translatedDesc = await translateText(vietnameseDesc, 'en');
      document.getElementById('description_en').value = translatedDesc;
    } finally {
      this.textContent = '🌐 Auto Translate';
      this.disabled = false;
    }
  });
});
</script>
@endpush

@push('styles')
<style>
.custom-spin-btns {
  position: absolute;
  right: 0.25rem;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  gap: 1px;
  z-index: 10;
}
.custom-spin-btn {
  width: 1.25rem;
  height: 1.1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f1f5f9;
  color: #6366f1;
  border-radius: 0.25rem;
  border: none;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
  font-size: 0.9rem;
  padding: 0;
}
.custom-spin-btn:hover {
  background: #6366f1;
  color: #fff;
}
.dark .custom-spin-btn {
  background: #1e293b;
  color: #a5b4fc;
}
.dark .custom-spin-btn:hover {
  background: #6366f1;
  color: #fff;
}
</style>
@endpush

@push('scripts')
<script>
function customSpin(fieldId, step) {
  const field = document.getElementById(fieldId);
  if (!field) return;
  let currentValue = field.value === '' ? 0 : parseInt(field.value);
  if (isNaN(currentValue)) currentValue = 0;
  let newValue = currentValue + step;
  if (field.hasAttribute('min')) {
    const min = parseInt(field.getAttribute('min'));
    if (!isNaN(min)) newValue = Math.max(min, newValue);
  }
  if (field.hasAttribute('max')) {
    const max = parseInt(field.getAttribute('max'));
    if (!isNaN(max)) newValue = Math.min(max, newValue);
  }
  field.value = newValue;
  field.dispatchEvent(new Event('input', { bubbles: true }));
  field.dispatchEvent(new Event('change', { bubbles: true }));
}
</script>
@endpush
