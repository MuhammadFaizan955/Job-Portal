<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification Email</title>
</head>
<body>
   <h1>Job Application Notification</h1>

<p>Dear {{ $mailData['employer']->name }},</p>
<p>{{ $mailData['user']->name }} has applied for your job: <strong>{{ $mailData['job']->title }}</strong>.</p>

<p>Applicant Details:</p>
<ul>
    <li>Name: {{ $mailData['user']->name }}</li>
    <li>Email: {{ $mailData['user']->email }}</li>
    <li>Phone: {{ $mailData['user']->phone }}</li>
</ul>

</body>
</html>
