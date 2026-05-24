<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your new account</title>
</head>
<body>
  <div style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2 style="color: #0d6efd;">Your ATS report account is ready</h2>
    <p>Hi {{ $user->name }},</p>
    <p>We received your resume and created an account for you so you can view the ATS report.</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please log in using the link below and then return to your ATS report:</p>
    <p>
      <a href="{{ $loginUrl }}" style="display:inline-block;padding:12px 18px;background:#0d6efd;color:#fff;border-radius:6px;text-decoration:none;">Log in to your account</a>
    </p>
    <p>If you did not request this account, please ignore this email.</p>
    <p>Thanks,<br/>The CareerElevate Team</p>
  </div>
</body>
</html>
