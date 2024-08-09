<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Nota de Entrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    @include('partials.header_pga')
    <h1>Reporte de Nota de Entrada</h1>
    <p><strong>Proveedor:</strong> {{ $supplier_name }}</p>
    <p><strong>Número de Factura:</strong> {{ $invoice_number }}</p>
    <p><strong>Fecha de Entrega:</strong> {{ $delivery_date }}</p>

    <h2>Materiales</h2>
    <table>
        <thead>
            <tr>
                <th>Código Material</th>
                <th>Unidad</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Costo Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materials as $material)
            <tr>
                <td>{{ $material['code_material'] }}</td>
                <td>{{ $material['unit_material'] }}</td>
                <td>{{ $material['description'] }}</td>
                <td>{{ $material['amount_entries'] }}</td>
                <td>{{ $material['cost_unit'] }}</td>
                <td>{{ $material['cost_total'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>