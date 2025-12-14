<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .receipt {
            background-color: white;
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 12px;
        }
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            font-size: 12px;
        }
        .info-block {
            flex: 1;
        }
        .info-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .info-value {
            color: #666;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f0f0f0;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #333;
            font-size: 12px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            margin: 30px 0;
            border-top: 2px solid #333;
            padding-top: 15px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 13px;
        }
        .total-row.final {
            font-size: 16px;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #999;
        }
        .logo {
            font-size: 24px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="logo">📚 BookClub Hub</div>
            <h1>RECIBO DE COMPRA</h1>
            <p>Sistema de Tienda de Libros</p>
        </div>

        <div class="receipt-info">
            <div class="info-block">
                <div class="info-label">Número de Recibo</div>
                <div class="info-value">{{ $receiptNumber }}</div>
            </div>
            <div class="info-block">
                <div class="info-label">Fecha</div>
                <div class="info-value">{{ $date }}</div>
            </div>
            <div class="info-block">
                <div class="info-label">Cliente</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Libro</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">Precio</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item['title'] }}</strong><br>
                            <span style="color: #999; font-size: 11px;">por {{ $item['author'] }}</span>
                        </td>
                        <td class="text-right">{{ $item['quantity'] }}</td>
                        <td class="text-right">${{ number_format($item['price'], 2) }}</td>
                        <td class="text-right"><strong>${{ number_format($item['total'], 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>
            @if($shipping > 0)
                <div class="total-row">
                    <span>Envío:</span>
                    <span>${{ number_format($shipping, 2) }}</span>
                </div>
            @else
                <div class="total-row">
                    <span>Envío:</span>
                    <span>GRATIS</span>
                </div>
            @endif
            <div class="total-row">
                <span>Impuestos (8%):</span>
                <span>${{ number_format($tax, 2) }}</span>
            </div>
            <div class="total-row final">
                <span>TOTAL A PAGAR:</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>✅ Recibo generado automáticamente por BookClub Hub</p>
            <p style="margin-top: 10px; color: #ccc;">Gracias por su compra</p>
        </div>
    </div>
</body>
</html>
