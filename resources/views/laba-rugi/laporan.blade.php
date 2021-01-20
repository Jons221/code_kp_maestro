<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <title>Laporan Laba Rugi</title>
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
    <h3 class="text-center">Laporan Laba Rugi</h3>
    <h3 class="text-center">Bulan dan Tahun {{$reportMonthYear}}</h3>
    <table class="table" width="100%">
        <!-- <tr class="table-header">
            <th></th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Total</th>
        </tr> -->
        <tr>
            <td width="25%">
                <p>Pendapatan</p>
            </td>
            <td width="25%"></td>
            <td width="25%" class="text-center">{{$totalPendapatan}}</td>
            <td width="25%" class="text-center"></td>
        </tr>
        <tr>
            <td>
                <p>Harga Pokok Penjualan</p>
            </td>
            <td class="text-center">{{$totalPurchase}}</td>
            <td></td>
            <td class="text-center"></td>
        </tr>
        <tr>
            <td>
                <p>Laba Kotor</p>
            </td>
            <td></td>
            <td class="text-center"></td>
            <td class="text-center">{{$totalLabaKotor}}</td>
        </tr>
        <tr>
            <td>
                <p>Beban-Beban:</p>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Beban Gaji</p>
            </td>
            <td class="text-center">{{$salaryTotal}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Beban asuransi</p>
            </td>
            <td class="text-center">{{$insureance_exp_total}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Beban Sewa</p>
            </td>
            <td class="text-center">{{$buildingExpenseTotal}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Beban Iklan</p>
            </td>
            <td class="text-center">{{$AdvExpense}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Beban Perlengkapan</p>
            </td>
            <td class="text-center">{{$EquipExpense}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Beban Penyusutan Peralatan</p>
            </td>
            <td class="text-center">{{$DepEquip}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Beban Rupa-rupa</p>
            </td>
            <td class="text-center">{{$OtherExpenses}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Beban Perawatan</p>
            </td>
            <td class="text-center">{{$MaintenanceExpenses}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Beban listrik dan air</p>
            </td>
            <td class="text-center">{{$ElectricWaterExpenses}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p style="margin-left:20mm">Total-beban</p>
            </td>
            <td></td>
            <td></td>
            <td class="text-center">{{$AllExpense}}</td>
        </tr>
        <tr class="table-header">
            <td >
                <p>Laba Bersih</p>
            </td>
            <td></td>
            <td></td>
            <td class="text-center"><strong>{{$totalLabaBersih}}</strong></td>
        </tr>
    </table>
</body>

</html>
