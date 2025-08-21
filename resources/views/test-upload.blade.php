<!DOCTYPE html>
<html>
<head>
    <title>Test Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test File Upload</h1>
    
    <form id="test-form" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" multiple accept="image/*">
        <button type="button" onclick="testUpload()">Test Upload</button>
        <button type="button" onclick="debugUpload()">Debug Upload</button>
        <button type="button" onclick="testSimpleUpload()">Test Simple Upload</button>
    </form>
    
    <div id="result"></div>
    
    <script>
    function testUpload() {
        const form = document.getElementById('test-form');
        const formData = new FormData(form);
        
        console.log('Testing upload...');
        console.log('Files:', form.querySelector('input[type="file"]').files);
        
        fetch('/admin/products/3/images', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('result').innerHTML = '<p style="color: red;">Error: ' + error.message + '</p>';
        });
    }
    
    function debugUpload() {
        const form = document.getElementById('test-form');
        const formData = new FormData(form);
        
        console.log('Debugging upload...');
        console.log('Files:', form.querySelector('input[type="file"]').files);
        
        fetch('/debug-upload', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Debug data:', data);
            document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch(error => {
            console.error('Debug error:', error);
            document.getElementById('result').innerHTML = '<p style="color: red;">Debug Error: ' + error.message + '</p>';
        });
    }
    
    function testSimpleUpload() {
        const form = document.getElementById('test-form');
        const formData = new FormData(form);
        
        console.log('Testing simple upload...');
        console.log('Files:', form.querySelector('input[type="file"]').files);
        
        fetch('/admin/test-file-upload', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Simple upload data:', data);
            document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch(error => {
            console.error('Simple upload error:', error);
            document.getElementById('result').innerHTML = '<p style="color: red;">Simple Upload Error: ' + error.message + '</p>';
        });
    }
    </script>
</body>
</html>
