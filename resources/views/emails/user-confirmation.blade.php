<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.confirmation_email_subject') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #d97706;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .field-value {
            color: #111827;
            font-size: 16px;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            border-left: 4px solid #d97706;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 12px;
        }
        h1 {
            margin: 0;
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('messages.confirmation_email_title') }}</h1>
    </div>

    <div class="content">
        <p>{{ __('messages.confirmation_email_greeting') }} <strong>{{ $data['name'] }}</strong>,</p>
        
        <p>{{ __('messages.confirmation_email_body') }}</p>

        <h3 style="color: #d97706; margin-top: 30px;">{{ __('messages.confirmation_email_summary') }}</h3>

        <div class="field">
            <div class="field-label">{{ __('messages.asunto') }}</div>
            <div class="field-value">{{ $data['subject'] }}</div>
        </div>

        @if(isset($data['interest']) && !empty($data['interest']))
        <div class="field">
            <div class="field-label">{{ __('messages.interested_in') }}</div>
            <div class="field-value">{{ $data['interest'] }}</div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">{{ __('messages.mensaje') }}</div>
            <div class="message-box">
                {{ $data['message'] }}
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">

        <p>{{ __('messages.confirmation_email_response_time') }}</p>

        @if(isset($data['phone']) && !empty($data['phone']))
        <p>{{ __('messages.confirmation_email_phone_contact') }}: <strong>{{ $data['phone'] }}</strong></p>
        @endif

        <p style="margin-top: 30px;">
            {{ __('messages.confirmation_email_thanks') }}<br>
            <strong>{{ config('app.name') }}</strong>
        </p>
    </div>

    <div class="footer">
        <p>{{ __('messages.aviso_no_responder') }}</p>
    </div>
</body>
</html>