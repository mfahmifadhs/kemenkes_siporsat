<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data->data_pendukung }}</title>
</head>

<body>
    <iframe src="{{ asset('dist/file/dakung/servis/' . $data->file_pendukung) }}"
        width="100%"
        height="715px">
    </iframe>
</body>

</html>
