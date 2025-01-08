<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $transaction->transaction_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 10px;
        }
        .section strong {
            font-weight: bold;
        }
        .table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .table th {
            text-align: center;
        }
        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 10px;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <p>Receipt</p>
            <p>{{ $transaction->transaction_number }}</p>
        </div>

        <!-- Transaction Info -->
        <div class="section">
            <p><strong>Date:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
        </div>

        <!-- Product Details -->
        <div class="section">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->transactionDetails as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ strtoupper($detail->product->code) }}</td>
                            <td>{{ $detail->product->name }}</td>
                            <td>Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp {{ number_format($detail->unit_price * $detail->qty, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Price -->
        <div class="total">
            <p>Total: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your purchase!</p>
        </div>
    </div>
</body>
</html>
