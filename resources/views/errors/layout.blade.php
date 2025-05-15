<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $code ?? 'Error' }} | NM DigitalHUB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background: #0b111d;
            color: #f2f4f8;
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
        .logo {
            max-width: 220px;
            margin-bottom: 30px;
        }
        h1 {
            font-size: 3.5rem;
            margin-bottom: 0.5rem;
            color: #66ccff;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #cccccc;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin: 0 10px;
        }
        .btn:hover {
            background-color: #0052a3;
        }
        .code {
            font-size: 5rem;
            font-weight: bold;
            color: #ff5e5e;
        }
    </style>
</head>
<body>
    <img src="{{ asset('images/nm-logo-full-color.png') }}" alt="NM DigitalHub Logo" class="logo">
    <div class="code">{{ $code ?? 'Error' }}</div>
    <h1>{{ $title ?? 'Oops! Something went wrong' }}</h1>
    <p>{{ $message ?? 'An unexpected error occurred. Please try again later.' }}</p>
    <div>
        <a href="{{ url('/') }}" class="btn">Back to Home</a>
        <a href="{{ route('support.report', ['error' => $code ?? 500]) }}" class="btn">Report this issue</a>
    </div>
</body>
</html>
