<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>
    
    <p><strong>Name:</strong> {{ $data['first_name'] }} {{ $data['last_name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    @if(!empty($data['phone']))
    <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
    @endif
    <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
    
    <h3>Message:</h3>
    <p>{{ $data['message'] }}</p>
    
    <hr>
    <p><small>This email was sent from the contact form on {{ config('app.name') }}</small></p>
</body>
</html>
