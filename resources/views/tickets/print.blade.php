<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ticket #{{ $ticket->id }}</title>
    <style>
        /* Tamaño para ticket de 80mm */
        @page { margin: 0; padding: 0; size: 80mm auto; }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 80mm;
            margin: 0;
            padding: 5px;
            line-height: 1.2;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .bold { font-weight: bold; }
        .small { font-size: 10px; }
    </style>
</head>
<body>
    <!-- Encabezado del ticket -->
    <div class="text-center">
        <div class="bold">{{ $business->legal_address }}</div>
        <div class="small">RUC: {{ $business->ruc }}</div>
        <div class="bold">TICKET DE VENTA</div>
        <div class="divider"></div>
    </div>

    <!-- Detalles de la venta -->
    <div class="text-left">
        <div>N° Ticket: {{ $ticket->id }}</div>
        <div>Fecha: {{ $date }}</div>
        <div class="divider"></div>
    </div>

    <!-- Datos del cliente -->
    <div class="text-left">
        <div>Cliente: {{ $ticket->dinner_name }}</div>
        <div>DNI: {{ $ticket->dni }}</div>
        <div class="divider"></div>
    </div>

    <!-- Productos/Servicios -->
    <div class="text-left">
        <div class="bold">PRODUCTOS/SERVICIOS</div>
        @foreach($ticket->ticket_details as $detail)
            <div>{{ $detail->service_name }} x{{ $detail->amount }}</div>
        @endforeach
        <div class="divider"></div>
    </div>

    <!-- Pie de página -->
    <div class="text-center small">
        <div>¡Gracias por su compra!</div>
        <div class="divider"></div>
        <div>Generado por {{ config('app.name') }}</div>
    </div>
</body>
</html>