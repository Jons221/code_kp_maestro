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
        $date_1=date("Y-m-d",$dateYear);
        $dateYear=date("Y-m-d H:i:s",$dateYear);
        $date_until=strtotime($request->month_until);
        $date_2=date("Y-m-d",$date_until);
        $date_until=date("Y-m-d H:i:s",$date_until);

        // neraca in
        $cash = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 3)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit-credit'));
        $TotalKas =$cash;
 
        $receivable = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 4)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit-credit'));

        $TotalAR =$receivable;

        $purchase = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 5)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $TotalPurcahse =$purchase;

        $prepaid_rent = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 8)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $prepaid_rent_total =$prepaid_rent;

        $supplies = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 7)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $total_supplies =$supplies; 

        $vehicle = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 12)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $Totalvehicle =$vehicle;

        $dep_vehicle = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 13)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit-credit'));
        $Totaldepvehicle =$dep_vehicle;

        $equipmnet = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 10)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $TotalEquipment =$equipmnet;

        $depequipmnet = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 41)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit-credit'));
        $TotalDepEquip =$depequipmnet;




        // total Out
        $payable = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 21)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('credit-debit'));
        $TotalAP =$payable;

        // $interest = DB::table('jurnal_lines')
        //     ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        //     ->where('akun_id', 58)
        //     ->whereMonth('jurnals.transaction_date', $month)
        //     ->whereYear('jurnals.transaction_date', $year)
        //     ->sum(DB::raw('credit - debit'));
        $TotalBunga =0 ;

        //     ->sum(DB::raw('debit - credit'));

        // $bank = DB::table('jurnal_lines')
        //     ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        //     ->where('akun_id', 57)
        //     ->whereMonth('jurnals.transaction_date', $month)
        //     ->whereYear('jurnals.transaction_date', $year)
        //     ->sum(DB::raw('debit - credit'));
        $TotalBank =0;

        $capital = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 27)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('credit - debit'));
        $TotalCapital =$capital;

        $retained_earn = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 57)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('credit - debit'));
        $retained_earn_total =$retained_earn;

        
        
        // Perbuahan modal

        $sales = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 29)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('credit-debit'));
        $salesTotal =$sales;


        $purchase = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 32)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit-credit'));
        $purchaseTotal =$purchase;

        $salary = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 45)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $salaryTotal =$salary;

        $insureance_exp = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 49)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $insureance_exp_total =$insureance_exp;
        
        $bulding_expense = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 48)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $buildingExpenseTotal =$bulding_expense;

        $adv = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 38)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $AdvExpense =$adv;

        $acc_equip_expense = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 47)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $AccEquipExpense =$acc_equip_expense;

        $acc_vechicle_expense = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 60)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $AccVechicleExpense =$acc_vechicle_expense;

        $other_expenses = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 55)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $OtherExpenses =$other_expenses;

        $maintenance_expenses = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 58)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $MaintenanceExpenses =$maintenance_expenses;

        $electricwaterExpenses = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 59)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $ElectricWaterExpenses =$electricwaterExpenses;

        $prive = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 28)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $Totalprive =$prive;


        
 

        // count all neraca
        // $TotalAmountBulding = $TotalBulding-$DepBulding;

        $totalPendapatan = $salesTotal;
        $totalLabaKotor = $totalPendapatan - $purchaseTotal;
        $AllExpense = $salaryTotal+$insureance_exp_total+$buildingExpenseTotal+$AdvExpense+$OtherExpenses+$MaintenanceExpenses+$ElectricWaterExpenses+$AccEquipExpense+$AccVechicleExpense;
        $totalLabaBersih =$totalLabaKotor-$AllExpense;

        $TotalPerubahan =$totalLabaBersih-$Totalprive;

        $TotalAmountvehicle = $Totalvehicle+$Totaldepvehicle;
        $TotalAmountEquiptment = $TotalEquipment-$TotalDepEquip;
        $TotalIn=$TotalKas+$TotalAR+$TotalPurcahse+$prepaid_rent_total+$total_supplies+$Totalvehicle+$Totaldepvehicle+$TotalEquipment+$TotalDepEquip;
        $TotalOut=$TotalAP+$TotalBunga+$TotalBank+$TotalCapital+$retained_earn_total+$TotalPerubahan;
        

        $pdf = PDF::loadview('neraca.laporan',
            [
                'TotalKas' => $TotalKas,
                'TotalAP' => $TotalAP,
                'TotalAR' => $TotalAR,
                'TotalPerubahan'=>$TotalPerubahan,
                'prepaid_rent_total'=>$prepaid_rent_total,
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
                'reportMonthYear' => ' '. $date_1 . ' Tahun ' . $date_2,
            ]
        );
        return $pdf->stream('laporan-neraca-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
