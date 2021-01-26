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

class LabaRugiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laba-rugi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        // return Excel::download(new LabaRugiExport($request->month), 'laba-rugi.xlsx');

        $purchaseTotal = 0;
        $salesTotal = 0;
        $salesDiscountTotal = 0;
        $salesReturTotal = 0;
        $otherSalesTotal = 0;

        $salaryTotal = 0;
        $buildingExpenseTotal = 0;
        $equipmentTotal = 0;
        $freightOutTotal = 0;
        $otherExpenseTotal = 0;
        $administrationExpenseTotal = 0;
        $totalPendapatan=0;
        $AdvExpense=0;
        $EquipExpense=0;
        $DepEquip=0;
        $OtherExpenses=0;
        $AllExpense=0;
        $totalLabaKotor=0;

        // month and year
        $dateYear=strtotime($request->month);
        $date_1=date("Y-m-d",$dateYear);
        $dateYear=date("Y-m-d H:i:s",$dateYear);
        $date_until=strtotime($request->month_until);
        $date_2=date("Y-m-d",$date_until);
        $date_until=date("Y-m-d H:i:s",$date_until);

   
        //sales
        // $sales = JurnalDetail::where('akun_id', 29)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('credit'));
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

        //salary  Office Salaries Expense
        // $salary = JurnalDetail::where('akun_id', 45)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
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
        
        // Building
        // $bulding_expense = JurnalDetail::where('akun_id', 16)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $bulding_expense = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 48)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $buildingExpenseTotal =$bulding_expense;

        // Advertising Expense
        // $adv = JurnalDetail::where('akun_id', 38)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $adv = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 38)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $AdvExpense =$adv;

        // Equipment
        // $equip_expense = JurnalDetail::where('akun_id', 10)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $supplies_expense = DB::table('jurnal_lines')
        //     ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        //     ->where('akun_id', 10)
        //     ->whereMonth('jurnals.transaction_date', $month)
        //     ->whereYear('jurnals.transaction_date', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $SuppliesExpense =$supplies_expense;

        // Acc. Depre. Equipment
        // $dep_equip = JurnalDetail::where('akun_id', 11)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $acc_equip_expense = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 60)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $AccEquipExpense =$acc_equip_expense;

        $acc_vechicle_expense = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 61)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $AccVechicleExpense =$acc_vechicle_expense;

        // Other Expenses
        // $other_expenses = JurnalDetail::where('akun_id', 55)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
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

 

        // count all laba dan rugi
        $totalPendapatan = $salesTotal;
        $totalLabaKotor = $totalPendapatan - $purchaseTotal;
        $AllExpense = $salaryTotal+$insureance_exp_total+$buildingExpenseTotal+$AdvExpense+$OtherExpenses+$MaintenanceExpenses+$ElectricWaterExpenses+$AccVechicleExpense+$AccEquipExpense;
        $totalLabaBersih =$totalLabaKotor-$AllExpense;
        // LabaRugi::create([
        //     'laba_rugi' => $totalLabaBersihOperasional,
        // ]);

        $pdf = PDF::loadview('laba-rugi.laporan',
            [
                'totalPendapatan' => $totalPendapatan,
                'insureance_exp_total'=>$insureance_exp_total,
                'salesTotal' => $salesTotal,
                'AdvExpense' => $AdvExpense,
                'OtherExpenses' => $OtherExpenses,
                'MaintenanceExpenses'=>$MaintenanceExpenses,
                'ElectricWaterExpenses'=>$ElectricWaterExpenses,
                'AllExpense' => $AllExpense,
                'salaryTotal' => $salaryTotal,
                'buildingExpenseTotal' => $buildingExpenseTotal,
                'AccEquipExpense'=>$AccEquipExpense,
                'AccVechicleExpense'=>$AccVechicleExpense,
                'reportMonthYear' => ''. $date_1 . ' Tahun ' . $date_2,
                'totalLabaKotor' => $totalLabaKotor,
                'totalPurchase' => $purchaseTotal,
                'totalLabaBersih' => $totalLabaBersih,
            ]
        );
        return $pdf->stream('laporan-laba-rugi-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
