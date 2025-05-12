<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            margin: 0;
            background-color: #f9fafb;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .content {
            margin-bottom: 30px;
        }
        .content h1, .content h2, .content h3 {
            color: #2563eb;
            margin-top: 24px;
            margin-bottom: 16px;
        }
        .content p {
            margin-top: 0;
            margin-bottom: 16px;
        }
        .content ul, .content ol {
            margin-bottom: 16px;
        }
        .content a {
            color: #2563eb;
            text-decoration: none;
        }
        .content a:hover {
            text-decoration: underline;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2563eb;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 16px 0;
        }
        .button:hover {
            background-color: #1d4ed8;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #777;
            font-size: 0.8em;
        }
        .rtl {
            direction: rtl;
            text-align: right;
        }
    </style>
</head>
<body dir="{{ app()->getLocale() === 'he' ? 'rtl' : 'ltr' }}">
    <div class="container">
        <div class="content {{ app()->getLocale() === 'he' ? 'rtl' : '' }}">
            {!! $content !!}
        </div>
        
        @php
            $mailSettings = \App\Models\MailSetting::getActiveSettings();
            $signature = $mailSettings ? $mailSettings->signature : null;
        @endphp
        
        @if($signature)
            <div class="footer {{ app()->getLocale() === 'he' ? 'rtl' : '' }}">
                {!! $signature !!}
            </div>
        @else
            <div class="footer {{ app()->getLocale() === 'he' ? 'rtl' : '' }}">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </div>
        @endif
    </div>
</body>
</html>