<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Upload to admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
</head>

<body>
  <form action="{{ route('uploadImage') }}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="file" name="image">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit" class="btn btn-primary">Upload</button>
  </form>
</body>

</html>
