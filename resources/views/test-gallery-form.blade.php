<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Gallery Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .result { margin-top: 20px; padding: 10px; background: #f8f9fa; border: 1px solid #dee2e6; }
    </style>
</head>
<body>
    <h1>Test Gallery Upload</h1>
    
    <form method="POST" action="/debug-gallery-upload" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label>Gallery Images:</label>
            <input type="file" name="gallery_images[]" multiple accept="image/*">
        </div>
        
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="Test Product">
        </div>
        
        <button type="submit">Upload</button>
    </form>
    
    <div id="result" class="result" style="display: none;"></div>
    
    <script>
        document.querySelector('form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const resultDiv = document.getElementById('result');
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = 'Uploading...';
            
            try {
                const response = await fetch('/debug-gallery-upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                resultDiv.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            } catch (error) {
                resultDiv.innerHTML = '<p>Error: ' + error.message + '</p>';
            }
        });
    </script>
</body>
</html>
