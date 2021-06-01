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
    <h1 class="text-center">Maestro Jaya</h1>
    <h2 class="text-center">Laporan Neraca</h2>
    <h3 class="text-center">Bulan dan Tahun {{$reportMonthYear}}</h3>
    <br/>
    <table class="table" width="100%">
        <tr class="table-header">
            <th>Nama Akun</th>
            <th>Jumlah</th>
            <th>Nama Akun</th>
            <th>Jumlah</th>
        </tr>
        <tr>
            <td>
                <p>Kas</p>
            </td>
            <td class="text-center">{{number_format($TotalKas)}}</td>
            <td >Utang usaha</td>
            <td class="text-center">{{number_format($TotalAP)}}</td>
        </tr>
        <tr>
            <td>
                <p>Piutang</p>
            </td>
            <td class="text-center">{{number_format($TotalAR)}}</td>
            <td>Utang bunga</td>
            <td class="text-center">{{number_format($TotalBunga)}}</td>
        </tr>
        <tr>
            <td>
                <p>Sewa dibayar muka</p>
            </td>
            <td class="text-center">{{number_format($TotalPurcahse)}}</td>
            <td>Utang Bank</td>
            <td class="text-center">{{number_format($TotalBank)}}
            </td>
        </tr>
        <tr>
            <td>
                <p>Asuransi dibayar dimuka</p>
            </td>
            <td class="text-center">{{number_format($prepaid_rent_total)}}</td>
            <td>Modal</td>
            <td class="text-center">{{number_format($TotalCapital)}}</td>
        </tr>
        <tr>
            <td>
                <p>Perlengkapan</p>
            </td>
            <td class="text-center">{{number_format($total_supplies)}}</td>
            <td>Laba ditahan</td>
            <td class="text-center">{{number_format($retained_earn_total)}}</td>
        </tr>
        <tr>
            <td>
                <p>Kendaraan </p>
            </td>
            <td class="text-center">{{number_format($Totalvehicle)}}</td>
            <td>Laba Berjalan</td>
            <td class="text-center">{{number_format($TotalPerubahan)}}</td>
        </tr>
        <tr>
            <td>
                <p>Akun Depr. Kendaraan </p>
            </td>
            <td class="text-center">{{number_format($Totaldepvehicle)}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p >Peralatan </p>
            </td>
            <td class="text-center">{{number_format($TotalEquipment)}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Akun Depr. Perlatan </p>
            </td>
            <td class="text-center">{{number_format($TotalDepEquip)}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr class="table-header">
            <td>
                <p>Jumlah</p>
            </td>
            <td class="text-center">{{number_format($TotalIn)}}</td>
            <td>Jumlah</td>
            <td class="text-center">{{number_format($TotalOut)}}</td>
        </tr>
    </table>
</body>

</html>
