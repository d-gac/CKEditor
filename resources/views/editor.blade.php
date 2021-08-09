<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form method="POST" action='{{url('/editor/'. ($path ? $path : ''))}}'>

    @csrf
<textarea class="form-control" id="summary-ckeditor" name="summary-ckeditor">{{ $dane ? $dane : '' }}</textarea>
    <input type="submit" name="send" value="Submit">
    <input type="reset" name="reset" value="Reset">
</form>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'summary-ckeditor', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form',
    });
</script>


</body>
</html>
