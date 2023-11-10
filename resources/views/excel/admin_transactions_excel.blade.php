<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transactions Excel</title>

</head>
<body>
@php
    $styleCss = 'style';
@endphp
<table>
    <thead>
    <tr>
        <th {{$styleCss}}="width: 200%"><b>Payment Date</b></th>
        <th {{$styleCss}}="width: 170%"><b>Invoice ID</b></th>
        <th {{$styleCss}}="width: 180%"><b>Client Name</b></th>
        <th {{$styleCss}}="width: 180%"><b>Payment Amount</b></th>
        <th {{$styleCss}}="width: 200%"><b>Payment Approved</b></th>
        <th {{$styleCss}}="width: 160%"><b>Payment Mode</b></th>
        <th {{$styleCss}}="width: 160%"><b>Status</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat(currentDateFormat()) }} {{ \Carbon\Carbon::parse($payment->payment_date)->isoFormat('hh:mm A') }}</td>
            <td>{{ $payment->invoice->invoice_id }}</td>
            <td>{{ $payment->invoice->client->user->full_name }}</td>
            <td>{{ $payment->amount }}</td>
            <td>{{\App\Models\Payment::PAYMENT_APPROVE[$payment->is_approved]}}</td>
            @if($payment->payment_mode == \App\Models\Payment::MANUAL)
                <td> Manual</td>
            @elseif($payment->payment_mode == \App\Models\Payment::STRIPE)
                <td> Stripe</td>
            @elseif($payment->payment_mode == \App\Models\Payment::PAYPAL)
                <td> Paypal</td>
            @elseif($payment->payment_mode == \App\Models\Payment::RAZORPAY)
                <td> Razorpay</td>
            @elseif($payment->payment_mode == \App\Models\Payment::CASH)
                <td> Cash</td>
            @endif

            @if($payment->is_approved == \App\Models\Payment::APPROVED)
                <td> Paid</td>
            @elseif($payment->is_approved == \App\Models\Payment::PENDING)
                <td> Processing</td>
            @elseif($payment->is_approved == \App\Models\Payment::REJECTED)
                <td> Denied</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
