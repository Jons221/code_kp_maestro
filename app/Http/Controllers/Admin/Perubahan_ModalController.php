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

class Perubahan_ModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('perubahan_modal.index');
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

        $acc_office_equip_expense = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 62)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit - credit'));
        $AccOfficeEquipExpense =$acc_office_equip_expense;

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

        $capital = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 27)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('credit - debit'));
        $TotalCapital =$capital;

        $prive = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 28)
            ->whereBetween('jurnals.transaction_date', [$dateYear,$date_until])
            ->sum(DB::raw('debit-credit'));
        $Totalprive =$prive;

 

        // count all laba dan rugi
        $totalPendapatan = $salesTotal;
        $totalLabaKotor = $totalPendapatan - $purchaseTotal;
        $AllExpense = $salaryTotal+$insureance_exp_total+$buildingExpenseTotal+$AdvExpense+$OtherExpenses+$MaintenanceExpenses+$ElectricWaterExpenses+$AccEquipExpense+$AccVechicleExpense+$AccOfficeEquipExpense;
        $totalLabaBersih =$totalLabaKotor-$AllExpense;

        $TotalPerubahan =$TotalCapital+$totalLabaBersih-$Totalprive;


        // LabaRugi::create([
        //     'laba_rugi' => $totalLabaBersihOperasional,
        // ]);

        $pdf = PDF::loadview('perubahan_modal.laporan',
            [
                'TotalCapital' => $TotalCapital,
                'reportMonthYear' => ' '. $date_1 . ' - ' . $date_2,
                'TotalCapital' => $TotalCapital,
                'Totalprive' => $Totalprive,
                'totalLabaBersih' => $totalLabaBersih,
                'TotalPerubahan'=>$TotalPerubahan,
            ]
        );
        return $pdf->stream('laporan-perubahan_modal-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
