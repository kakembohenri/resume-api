<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
</head>
<body style="font-family: sans-serif">
    <p>Click on the link below to verify your account</p>
    <a href={{'http://localhost:5173/verify?email='.$mailData['email'].'&token='.$mailData['token']}} target="_blank">{{'http://localhost:5173/verify?email='.$mailData['email'].'&token='.$mailData['token']}}
    </a>
</body>
</html>

