<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@php
    $border = "1px solid black";
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}.pdf</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Nunito, sans-serif;
        }
        table {
            width: 100%;
        }
        th, td {
            padding: 10px;
            border: {{ $border }};
        }
    </style>
</head>

<body class="font-sans antialiased">
    <h1>{{ $title }}</h1>
    <table cellspacing="0">
        <thead>
            <tr>
                <th>User</th>
                <th>Food</th>
                <th>Drink</th>
                <th>Other</th>
            </tr>
        </thead>
        <tbody> @foreach($purchase->data as $user_id => $order)
            <tr>
                <td>{{ $order['name'] ?? 'N/A' }}</td>
                <td>{{ $order['food'] ?? 'N/A' }}</td>
                <td>{{ $order['drink'] ?? 'N/A' }}</td>
                <td>{{ $order['other'] ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
