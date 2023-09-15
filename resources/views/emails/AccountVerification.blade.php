<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
</head>
<body style="font-family: sans-serif">
    <p>Dear {{ $mailData['name'] }},</p>
    <p style="margin: 1rem 0;">Thank you for choosing Resume Builder. To ensure the security of your account and maintain the quality of our services, we require you to complete your account verification.</p>
    <p style="margin: 1rem 0;"> Click on the button below to verify your email address and complete your account setup.</p>
    <a href={{env('BASE_API').'#/verify/'.$mailData['email'].'/'.$mailData['token']}} target="_blank" style="text-decoration: none;
    color: #000000ad;
    padding: 1rem 0.5rem;
    background: yellow;">Verify My Account
    </a>
    <p style="margin: 1rem 0;">Your security is our priority. If you did not create an account on Resume Builder, please disregard this email.</p>
    <p>Thank you for choosing Resume Builder. If you have any questions or need assistance, please don't hesitate to contact our support team at 
        <a href="mailto:resumebuilder@livecvtest.com">
            resumebuilder@livecvtest.com
        </a>
    </p>
    <p style="margin: 2rem 0;">Best Regards,</p>
    <p style="margin: 1rem 0;">The Resume Builder Team</p>
</body>
</html>

