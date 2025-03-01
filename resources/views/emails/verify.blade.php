


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        @media (max-width: 600px) {
            .container {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <p>Hi {{ $name }},</p>
      
        <p><a href="{{ $verification_url }}" class="btn"  >Verify Email</a></p>
    </div>

</body>
</html>