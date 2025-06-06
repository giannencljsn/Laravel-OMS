<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Notification</title>
</head>
<body>
    <h1>Order Details</h1>
    <p>Dear Customer,</p>
    <p>Thank you for your order! Here are the details:</p>
    <ul>
        <li><b>Pickup Code:  {{ $order->pickup_code }} <b></li>
        <li>Order ID: {{ $order->order_id }}</li>
        <li>Invoice ID: {{ $order->invoice_id }}</li>
        <li>Status: {{ $order->status }}</li>
        <li>Availability Date: {{ \Carbon\Carbon::parse($order->availability_date)->format('Y-m-d') }}</li>
      
    </ul>
    <p>We will notify you once your order is ready for pickup. Thank you for choosing us!</p>
</body>
</html>