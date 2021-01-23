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

        // neraca in
        $cash = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 3)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit-credit'));
        $TotalKas =$cash;
 
        $receivable = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 4)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit-credit'));

        $TotalAR =$receivable;
            $purchase = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 5)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalPurcahse =$purchase;

        $prepaid_rent = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 8)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $prepaid_rent_total =$prepaid_rent;

        $supplies = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 7)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $total_supplies =$supplies; 

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

        $equipmnet = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 10)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalEquipment =$equipmnet;

        $depequipmnet = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 41)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('debit - credit'));
        $TotalDepEquip =$depequipmnet;




        // total Out
        $payable = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 21)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('credit-debit'));
        $TotalAP =$payable;

        $interest = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 58)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('credit - debit'));
        $TotalBunga =$interest ;

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
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('credit - debit'));
        $TotalCapital =$capital;

        $retained_earn = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 57)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->sum(DB::raw('credit - debit'));
        $retained_earn_total =$retained_earn;

        
        // $note_reciev = DB::table('jurnal_lines')
        //     ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        //     ->where('akun_id', 6)
        //     ->whereMonth('jurnals.transaction_date', $month)
        //     ->whereYear('jurnals.transaction_date', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $note_reciev_total =$note_reciev; 

        

        // perlekapan = Machine
        // $perlekapan = JurnalDetail::where('akun_id', 14)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));

        // $perlekapan = DB::table('jurnal_lines')
        //     ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        //     ->where('akun_id', 7)
        //     ->whereMonth('jurnals.transaction_date', $month)
        //     ->whereYear('jurnals.transaction_date', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $TotalPerlekapan =$perlekapan;

        // land
        // $land = JurnalDetail::where('akun_id', 18)
        //     ->whereMonth('created_at', $month)
        //     ->whereYear('created_at', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $land = DB::table('jurnal_lines')
        //     ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        //     ->where('akun_id', 18)
        //     ->whereMonth('jurnals.transaction_date', $month)
        //     ->whereYear('jurnals.transaction_date', $year)
        //     ->sum(DB::raw('debit - credit'));
        // $TotalLand =$land;

        

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


        
 

        // count all neraca
        // $TotalAmountBulding = $TotalBulding-$DepBulding;
        $TotalAmountvehicle = $Totalvehicle+$Totaldepvehicle;
        $TotalAmountEquiptment = $TotalEquipment-$TotalDepEquip;
        $TotalIn=$TotalKas+$TotalAR+$TotalPurcahse+$prepaid_rent_total+$total_supplies+$Totalvehicle+$Totaldepvehicle+$TotalEquipment+$TotalDepEquip;
        $TotalOut=$TotalAP+$TotalBunga+$TotalBank+$TotalCapital+$retained_earn_total;

        $pdf = PDF::loadview('neraca.laporan',
            [
                'TotalKas' => $TotalKas,
                'TotalAP' => $TotalAP,
                'TotalAR' => $TotalAR,
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
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
            ]
        );
        return $pdf->stream('laporan-neraca-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
