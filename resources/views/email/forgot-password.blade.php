<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
</head>
<body>
   <h1>Hello {{$mailData['user']->name}}</h1>

<p>We received a request to reset your password. Click the link below to reset it:</p>

<p><a href="{{ route('account.reset.password', $mailData['token']) }}">Reset Password</a></p>

<p>If you didn't request a password reset, please ignore this email.</p>

</body>
</html>

