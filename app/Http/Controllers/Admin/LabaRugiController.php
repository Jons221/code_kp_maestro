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
        $month=date("m",$dateYear);
        $year=date("Y",$dateYear);

   
        //sales
        // $sales = JurnalDetail::where('akun_id', 29)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('credit'));
        $sales = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 29)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('credit-debit'));
        $salesTotal =$sales;


        $purchase = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 32)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
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
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $salaryTotal =$salary;
        
        // Building
        // $bulding_expense = JurnalDetail::where('akun_id', 16)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $bulding_expense = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 16)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
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
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $AdvExpense =$adv;

        // Equipment
        // $equip_expense = JurnalDetail::where('akun_id', 10)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $equip_expense = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 10)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $EquipExpense =$equip_expense;

        // Acc. Depre. Equipment
        // $dep_equip = JurnalDetail::where('akun_id', 11)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $dep_equip = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 11)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $DepEquip =$dep_equip;

        // Other Expenses
        // $other_expenses = JurnalDetail::where('akun_id', 55)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        $other_expenses = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 55)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $OtherExpenses =$other_expenses;

 

        // count all laba dan rugi
        $totalPendapatan = $salesTotal;
        $totalLabaKotor = $totalPendapatan - $purchaseTotal;
        $AllExpense = $salaryTotal+$buildingExpenseTotal+$AdvExpense+$EquipExpense+$DepEquip+$OtherExpenses;
        $totalLabaBersih =$totalLabaKotor-$AllExpense;
        // LabaRugi::create([
        //     'laba_rugi' => $totalLabaBersihOperasional,
        // ]);

        $pdf = PDF::loadview('laba-rugi.laporan',
            [
                'totalPendapatan' => $totalPendapatan,
                'salesTotal' => $salesTotal,
                'AdvExpense' => $AdvExpense,
                'EquipExpense' => $EquipExpense,
                'DepEquip' => $DepEquip,
                'OtherExpenses' => $OtherExpenses,
                'AllExpense' => $AllExpense,
                'salaryTotal' => $salaryTotal,
                'buildingExpenseTotal' => $buildingExpenseTotal,
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
                'totalLabaKotor' => $totalLabaKotor,
                'totalPurchase' => $purchaseTotal,
                'totalLabaBersih' => $totalLabaBersih,
            ]
        );
        return $pdf->stream('laporan-laba-rugi-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}