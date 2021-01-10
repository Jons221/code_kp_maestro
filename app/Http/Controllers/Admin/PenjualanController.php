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
use Illuminate\Support\Arr;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        // return Excel::download(new LabaRugiExport($request->month), 'laba-rugi.xlsx');

        $TotalSales= 0;
        $TotalAR=0;
        $TotalPiutangusaha=0;
        $TotalSerbaserbi=0;
        $Totaldiscount=0;

        

        // month and year
        $dateYear=strtotime($request->month);
        $month=date("m",$dateYear);
        $year=date("Y",$dateYear);
   
        $acc_ar = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->join('invoices', 'jurnal_lines.invoice_id', '=', 'invoices.id')
            ->join('partners', 'invoices.partner_id', '=', 'partners.id')
            ->select('debit', 'partners.name', 'jurnals.transaction_date','partners.id', 'jurnal_lines.description')
            // ->where('invoices.type', '=', 'sale')
            // ->where('invoices.state', '=', 'done')
            ->where('debit', '>', 0)
            ->where('akun_id', '=', 4)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->get();

        $data_sales =[];
        $data_sales_id =[];
        $id=NULL;
        for ($i=0; $i<count($acc_ar); $i++){
            $id =(string)$acc_ar[$i]->id;
            $a =in_array($id, $data_sales_id);
            // if ($a == false){
                $data_sales_id[] = (string)$acc_ar[$i]->id;
                $data_sales[] = $acc_ar[$i];
                end($data_sales)->AR = $acc_ar[$i]->debit;
                end($data_sales)->sales = 0;
                $TotalAR += $acc_ar[$i]->AR;
            // }
            // else{
            //     $key= array_search($id, $data_sales_id); 
            //     $amount =$data_sales[$key]->grand_total + $sales[$i]->grand_total;
            //     $data_sales[$key]->grand_total = $amount;
            //     $TotalPenjualan += $sales[$i]->grand_total;
            // }
        }

        $sales = DB::table('jurnal_lines')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->join('invoices', 'jurnal_lines.invoice_id', '=', 'invoices.id')
            ->join('partners', 'invoices.partner_id', '=', 'partners.id')
            ->select('jurnal_lines.credit', 'partners.name', 'jurnals.transaction_date','jurnal_lines.id','partners.id', 'jurnal_lines.description')
            ->where('akun_id', '=', 29)
            ->where('credit', '>', 0)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->get();

        for ($i=0; $i<count($sales); $i++){
            $id =(string)$sales[$i]->id;
            $a =in_array($id, $data_sales_id);
            // if ($a == false){
                $data_sales_id[] = (string)$sales[$i]->id;
                $data_sales[] = $sales[$i];
                end($data_sales)->sales = $sales[$i]->credit;
                end($data_sales)->AR = 0;
                $TotalSales += $sales[$i]->sales;
                
            // }
            // else{
            //     $key= array_search($id, $data_sales_id); 
            //     $amount =$data_sales[$key]->cash + $cash[$i]->amount;
            //     $data_sales[$key]->cash = $amount;
            //     $TotalKas += $cash[$i]->amount;
            // }
        }

        $data_sales = Arr::sort($data_sales, function($data)
        {
            return $data->transaction_date;
        });


        $pdf = PDF::loadview('penjualan.laporan',
            [
                'sales' => $data_sales,
                'TotalSales' => $TotalSales,
                'TotalAR' => $TotalAR,
                'TotalPiutangusaha' => $TotalPiutangusaha,
                'TotalSerbaserbi' => $TotalSerbaserbi,
                'Totaldiscount' => $Totaldiscount,
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
            ]
        );
        return $pdf->stream('laporan-penjualan-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
