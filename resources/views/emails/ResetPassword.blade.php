<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Better Law</title>
</head>
<body style="font-family: sans-serif">
    <h4>Dear Distiguished User,</h4>
    <p style="margin: 1rem 0;">A password reset request was sent for your account. If it was not you please ignore this email and do not share the link below with any one.</p>
    <p style="margin: 1rem 0;"> Click on the button below to reset your password.</p>
    <a href={{env('BASE_API').'#/password-reset/'.$mailData['email'].'/'.$mailData['token']}} target="_blank" style="text-decoration: none;
    color: #000000ad;
    padding: 1rem 0.5rem;
    background: yellow;">Reset My Password
    </a>
    <p>Thank you for choosing Resume Builder. If you have any questions or need assistance, please don't hesitate to contact our support team at 
        <a href="mailto:resumebuilder@livecvtest.com">
            resumebuilder@livecvtest.com
        </a>
    </p>
    <p style="margin: 2rem 0;">Best Regards,</p>
    <p style="margin: 1rem 0;">The Resume Builder Team</p>
</body>
</html>

