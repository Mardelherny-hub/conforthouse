<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Consulta - {{ config('app.name') }}</title>
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
        .property-highlight {
            background-color: #fef3c7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #d97706;
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
        <h1>Nueva Consulta - {{ config('app.name') }}</h1>
    </div>

    <div class="content">
        <p>Has recibido una nueva consulta desde el sitio web.</p>

        <div class="field">
            <div class="field-label">Tipo de Formulario</div>
            <div class="field-value">{{ $data['form_type'] ?? 'Consulta General' }}</div>
        </div>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">

        <h3 style="color: #d97706; margin-top: 30px;">Datos del Cliente</h3>

        <div class="field">
            <div class="field-label">Nombre</div>
            <div class="field-value">{{ $data['name'] }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email</div>
            <div class="field-value">
                <a href="mailto:{{ $data['email'] }}" style="color: #d97706;">{{ $data['email'] }}</a>
            </div>
        </div>

        @if(isset($data['phone']) && !empty($data['phone']))
        <div class="field">
            <div class="field-label">Teléfono</div>
            <div class="field-value">
                <a href="tel:{{ $data['phone'] }}" style="color: #d97706;">{{ $data['phone'] }}</a>
            </div>
        </div>
        @endif

        @if(isset($data['subject']) && !empty($data['subject']))
        <div class="field">
            <div class="field-label">Asunto</div>
            <div class="field-value">{{ $data['subject'] }}</div>
        </div>
        @endif

        @if(isset($data['interest']) && !empty($data['interest']))
        <div class="field">
            <div class="field-label">Interesado en</div>
            <div class="field-value">{{ $data['interest'] }}</div>
        </div>
        @endif

        @if(isset($data['property_title']) && !empty($data['property_title']))
        <div class="property-highlight">
            <h4 style="margin-top: 0; color: #d97706;">🏠 Propiedad de Interés</h4>
            <div class="field">
                <div class="field-label">Propiedad</div>
                <div class="field-value">{{ $data['property_title'] }}</div>
            </div>
            @if(isset($data['property_reference']) && !empty($data['property_reference']))
            <div class="field">
                <div class="field-label">Referencia</div>
                <div class="field-value">{{ $data['property_reference'] }}</div>
            </div>
            @endif
        </div>
        @endif

        <div class="field">
            <div class="field-label">Mensaje</div>
            <div class="message-box">
                {{ $data['message'] }}
            </div>
        </div>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">

        <p style="margin-top: 30px; color: #6b7280; font-size: 14px;">
            <strong>Fecha:</strong> {{ date('d/m/Y H:i:s') }}
        </p>
    </div>

    <div class="footer">
        <p>Este es un email automático desde {{ config('app.name') }}</p>
        <p>No responder a este correo</p>
    </div>
</body>
</html>