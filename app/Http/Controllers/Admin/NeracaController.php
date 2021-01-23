<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\LabaRugiExport;
use App\Models\JurnalDetail;
use App\Models\LabaRugi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\LabaRugiExport;
use PDF;
use Illuminate\Support\Facades\DB;

class NeracaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('neraca.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        // return Excel::download(new LabaRugiExport($request->month), 'laba-rugi.xlsx');

        $TotalKas= 0;
        $TotalAP= 0;
        $TotalAR= 0;
        $TotalBunga= 0;
        $TotalPurcahse= 0;
        $TotalBank= 0;
        $TotalEquipment= 0;
        $TotalPerlekapan= 0;
        $TotalCapital= 0;
        $TotalLand= 0;
        $TotalBulding= 0;
        $DepBulding= 0;
        $OtherExpenses= 0;
        $TotalEquipment= 0;
        $TotalDepEquip= 0;
        $TotalIn= 0;
        $TotalOut = 0;
        $TotalAmountBulding=0;
        $TotalAmountEquiptment=0;

        

        // month and year
        $dateYear=strtotime($request->month);
        $month=date("m",$dateYear);
        $year=date("Y",$dateYear);

   
        //Cash
        // $cash = JurnalDetail::where('akun_id', 3)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));

        $cash = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 3)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit-credit'));
        $TotalKas =$cash;
        
        //total ap
        // $payable = JurnalDetail::where('akun_id', 21)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $payable = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 21)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('credit-debit'));
        $TotalAP =$payable;

        // total ar
        // $receivable = JurnalDetail::where('akun_id', 4)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $receivable = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 4)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit-credit'));
        $TotalAR =$receivable;

        // interest 
        // $interest = JurnalDetail::where('akun_id', 58)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $interest = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 58)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalBunga =$interest ;

        $retained_earn = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 58)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $retained_earn_total =$retained_earn;

        // purcahse
        // $purchase = JurnalDetail::where('akun_id', 5)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $purchase = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 5)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalPurcahse =$purchase;

        // bank
        // $bank = JurnalDetail::where('akun_id', 57)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));

        $bank = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 57)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalBank =$bank;

        $prepaid_rent = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 8)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $prepaid_rent_total =$prepaid_rent;

        $note_reciev = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 6)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $note_reciev_total =$note_reciev; 

        $supplies = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 7)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $total_supplies =$supplies; 

        // perlekapan = Machine
        // $perlekapan = JurnalDetail::where('akun_id', 14)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));

        $perlekapan = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 7)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalPerlekapan =$perlekapan;

        // capital
        // $capital = JurnalDetail::where('akun_id', 27)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $capital = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 27)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalCapital =$capital;

        // land
        // $land = JurnalDetail::where('akun_id', 18)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $land = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 18)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalLand =$land;

        $vehicle = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 12)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $Totalvehicle =$vehicle;

        $dep_vehicle = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 13)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $Totaldepvehicle =$dep_vehicle;

        // building
        // $building = JurnalDetail::where('akun_id', 16)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $building = DB::table('jurnal_lines')
        //     ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        //     ->where('akun_id', 16)
        //     ->whereMonth('jurnals.transaction_date', $month)
        //     ->whereYear('jurnals.transaction_date', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $TotalBulding =$building;

        // dep building
        // $depbuilding = JurnalDetail::where('akun_id', 17)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('credit'));
        // $depbuilding = DB::table('jurnal_lines')
        //     ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        //     ->where('akun_id', 17)
        //     ->whereMonth('jurnals.transaction_date', $month)
        //     ->whereYear('jurnals.transaction_date', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $DepBulding =$depbuilding;


        // Other Expenses
        // $other_expenses = JurnalDetail::where('akun_id', 55)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $OtherExpenses =$other_expenses;

        // equip
        // $equipmnet = JurnalDetail::where('akun_id', 10)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $equipmnet = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 10)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalEquipment =$equipmnet;

        // depequip
        // $depequipmnet = JurnalDetail::where('akun_id', 11)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $depequipmnet = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 41)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalDepEquip =$depequipmnet;
 

        // count all neraca
        // $TotalAmountBulding = $TotalBulding-$DepBulding;
        $TotalAmountvehicle = $Totalvehicle+$Totaldepvehicle;
        $TotalAmountEquiptment = $TotalEquipment-$TotalDepEquip;
        $TotalIn=$TotalKas+$TotalAR+$TotalPerlekapan+$TotalLand+$TotalAmountEquiptment+$prepaid_rent_total+$note_reciev_total+$TotalAmountvehicle;
        $TotalOut=$TotalAP+$TotalBunga+$TotalBank+$TotalCapital+$retained_earn_total;
        // $totalPendapatan = $salesTotal - ($salesDiscountTotal + $salesReturTotal);
        // $totalLabaKotor = $totalPendapatan - $purchaseTotal;
        // $totalBebanOperasional = $equipmentTotal + $freightOutTotal + $otherSalesTotal + $salaryTotal + $buildingExpenseTotal + $otherExpenseTotal + $administrationExpenseTotal;
        // $totalLabaBersihOperasional = $totalLabaKotor - $totalBebanOperasional;
        // $AllExpense = $salaryTotal+$buildingExpenseTotal+$AdvExpense+$EquipExpense+$DepEquip+$OtherExpenses;
        // $totalLabaKotor =$totalPendapatan+$AllExpense;

        $pdf = PDF::loadview('neraca.laporan',
            [
                'TotalKas' => $TotalKas,
                'TotalAP' => $TotalAP,
                'TotalAR' => $TotalAR,
                'prepaid_rent_total'=>$prepaid_rent_total,
                'note_reciev_total'=>$note_reciev_total,
                'total_supplies'=>$total_supplies,
                'retained_earn_total'=>$retained_earn_total,
                'TotalBunga' => $TotalBunga,
                'TotalPurcahse' => $TotalPurcahse,
                'TotalBank' => $TotalBank,
                'TotalPerlekapan' => $TotalPerlekapan,
                'TotalCapital' => $TotalCapital,
                'TotalLand' => $TotalLand,
                'Totalvehicle'=> $Totalvehicle,
                'Totaldepvehicle'=>$Totaldepvehicle,
                'TotalAmountvehicle'=>$TotalAmountvehicle,
                'TotalEquipment' => $TotalEquipment,
                'TotalDepEquip' => $TotalDepEquip,
                'TotalIn' => $TotalIn,
                'TotalOut' => $TotalOut,
                'TotalAmountEquiptment' => $TotalAmountEquiptment,
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
            ]
        );
        return $pdf->stream('laporan-neraca-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
