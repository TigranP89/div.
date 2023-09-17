<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send Mail</title>
</head>
<body>
<h1>Name: {{ $mailData['name'] }}</h1>

<p>Status: {{ $mailData['status'] }}</p>
<p>Comment: {{ $mailData['comment'] }}</p>
<p>Message: {{ $mailData['message'] }}</p>
</body>
</html>