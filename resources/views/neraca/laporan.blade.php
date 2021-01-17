<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <title>Laporan Neraca</title>
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
  .table-dark tbody + tbody {
    border-color: #dee2e6;
  }

  .table .thead-dark th {
    color: inherit;
    border-color: #dee2e6;
  }
</style>

<body>
    <h1 class="text-center">Laporan Neraca</h1>
    <h3 class="text-center">Bulan dan Tahun {{$reportMonthYear}}</h3>
    <br/>
    <br/>
    <table class="table" width="100%">
        <tr class="table-header">
            <th>Nama Rekening</th>
            <th>Jumlah</th>
            <th>Nama Rekening</th>
            <th>Jumlah</th>
        </tr>
        <tr>
            <td>
                <p>Kas</p>
            </td>
            <td class="text-center">{{$TotalKas}}</td>
            <td >Utang usah</td>
            <td class="text-center">{{$TotalAP}}</td>
        </tr>
        <tr>
            <td>
                <p>Piutang</p>
            </td>
            <td class="text-center">{{$TotalAR}}</td>
            <td>Utang bunga</td>
            <td class="text-center">{{$TotalBunga}}</td>
        </tr>
        <tr>
            <td>
                <p>Persedian barang dagangan</p>
            </td>
            <td class="text-center">{{$TotalPurcahse}}</td>
            <td>Utang Bank</td>
            <td class="text-center">{{$TotalBank}}
            </td>
        </tr>
        <tr>
            <td>
                <p>Perlengkapan</p>
            </td>
            <td class="text-center">{{$TotalPerlekapan}}</td>
            <td>Modal</td>
            <td class="text-center">{{$TotalCapital}}</td>
        </tr>
        <tr>
            <td>
                <p>Tanah</p>
            </td>
            <td class="text-center">{{$TotalLand}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Gedung ({{$TotalBulding}})</p>
            </td>
            <td class="text-center"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Akun Depr. Gedung ({{$DepBulding}})</p>
            </td>
            <td class="text-center"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p></p>
            </td>
            <td class="text-center">{{$TotalAmountBulding}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p >Perlatan ({{$TotalEquipment}})</p>
            </td>
            <td class="text-center"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Akun Depr. Perlatan</p>
            </td>
            <td class="text-center">{{$TotalDepEquip}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p></p>
            </td>
            <td class="text-center">{{$TotalAmountEquiptment}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr class="table-header">
            <td>
                <p>Jumlah</p>
            </td>
            <td class="text-center">{{$TotalIn}}</td>
            <td>Jumlah</td>
            <td>{{$TotalOut}}</td>
        </tr>
    </table>
</body>

</html>