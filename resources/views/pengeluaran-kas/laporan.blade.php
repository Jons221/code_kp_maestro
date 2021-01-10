<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <title>Laporan Penerimaan Kas</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
</head>
<style>
    .text-center {
        text-align: center !important;
    }

    .table {
        border-collapse: collapse !important;
        border: 1px solid black !important;

    }

    .table td,
    .table th {
        border-left: 1px solid black;
        background-color: #fff !important;
    }

    .table-header th,
    .table-header td {
        background-color: #fff !important;
        border: 1px solid black;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid black !important;
    }

    .table-dark {
        color: inherit;
    }

    .table-dark th,
    .table-dark td,
    .table-dark thead th,
    .table-dark tbody+tbody {
        border-color: #dee2e6;
    }

    .table .thead-dark th {
        color: inherit;
        border-color: #dee2e6;
    }

</style>

<body>
    <h1 class="text-center">Laporan Pengeluaran Kas</h1>
    <h3 class="text-center">Bulan dan Tahun {{$reportMonthYear}}</h3>
    <br />
    <table class="table" width="100%">
        <tr class="table-header">
            <th>Tanggal</th>
            <th>No Bukti</th>
            <th>Keterangan</th>
            <th>Ref</th>
            <th>Beban-beban</th>
            <th>Utang Dagang</th>
            <th>Pot. Pembelian</th>
            <th>Kas</th>
        </tr>
        @foreach($purchase as $value)
        <tr>
            <td>{{$value->transaction_date}}</td>
            <td>{{$value->description}}</td>
            <td>{{$value->name}}</td>
            <td></td>
            <td>{{$value->total_other}}</td>
            <td>{{$value->amount}}</td>
            <td></td>
            <td>{{$value->kas}}</td>
        </tr>
        @endforeach
        <tr class="table-header">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$totalpengeluaran}}</td>
        </tr>

    </table>
    
</body>

</html>
