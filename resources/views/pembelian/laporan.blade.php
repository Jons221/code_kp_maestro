<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <title>Laporan Pembelian</title>
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
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
    <h1 class="text-center">Laporan pembelian</h1>
    <h3 class="text-center">Bulan dan Tahun {{$reportMonthYear}}</h3>
    <br />
    <table class="table" width="100%">
        <tr class="table-header">
            <th  rowspan="2">Tanggal</th>
            <th rowspan="2">Keterangan</th>
            <th rowspan="2">Ref</th>
            <th >Debet</th>
            <th colspan="2">Kredit</th>
        </tr>
        <tr class="table-header">
            <th >kas</td>
            <th >Penjualan</td>
            <th >Piutang usaha</td>
        </tr>
     
        @foreach($sales as $value)
        <tr class="text-center">
            <td>{{$value->transaction_date}}</td>
            <td>{{$value->name}}</td>
            <td>{{$value->description}}</td>
            <td>{{$value->purchase}}</td>
            <td>{{$value->AP}}</td>
            <td></td>
        </tr>
        @endforeach
        <tr class="table-header text-center">
            <td ></td>
            <td></td>
            <td></td>
            <td>{{$TotalPurchase}}</td>
            <td>{{$TotalAP}}</td>
            <td></td>
        </tr>
    </table>
</body>

</html>

