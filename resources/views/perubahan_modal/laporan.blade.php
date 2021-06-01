<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <title>Laporan Perubahan Modal</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
</head>
<style>
.text-center {
  text-align: center !important;
}
.text-right {
  text-align: right !important;
}
.table {
    border-collapse: collapse !important;
    border: 1px solid black !important;

  }
  .table-header th,
  .table-header td {
    background-color: #fff !important;
    border: 1px solid black;
  }

  .table td,
  .table th {
    background-color: #fff !important;
    border-left: 1px solid black;
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
    <h1 class="text-center">Maestro Jaya</h1>
    <h1 class="text-center">Laporan Perubahan Modal</h1>
    <h3 class="text-center">Bulan dan Tahun {{$reportMonthYear}}</h3>
    <br/>
    <br/>
    <table class="table" width="100%">
        
        <tr>
            <td width="25%">
                <p>Modal Awal Per {{$reportMonthYear}}</p>
            </td>
            <td width="25%"></td>
            <td width="25%" class="text-center">{{number_format($TotalCapital)}}</td>
        </tr>
        <tr>
            <td>
                <p>Penambahan Modal</p>
            </td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
        <tr>
            <td >
                <p style="margin-left:20mm">Laba Bersih</p>
            </td>
            <td class="text-center">{{number_format($totalLabaBersih)}}</td>
            <td class="text-center"></td>
        </tr>
        <tr>
            <td >
                <p style="margin-left:20mm">Prive</p>
            </td>
            <td class="text-center">{{number_format($Totalprive)}}</td>
            <td class="text-center"></td>
        </tr>
        
        <tr>
            <td>
                <p >Modal Akhir</p>
            </td>
            <td class="text-center"></td>
            <td class="text-center">{{number_format($TotalPerubahan)}}</td>
        </tr>
     
    </table>
</body>

</html>
