<!DOCTYPE html>
<html>
<head>
    <title>Verification mail</title>
</head>
<body>
<p>Hi {{ $data['first_name'] }},</p>

<p>Your verification link is: <a href={{ $data['verificationLink'] }}>click here</a></p>

<p>Thank you!</p>
</body>
</html>