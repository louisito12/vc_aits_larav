<!DOCTYPE html>
<html>

<head>
    <title>Upload Excel File</title>
</head>

<body>
    <h2>Upload Excel File</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('excel.upload.handle') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Choose an Excel File:</label>
        <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required>
        <button type="submit">Upload</button>
    </form>
</body>

</html>
