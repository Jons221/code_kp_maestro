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

class PenerimaankasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penerimaan-kas.index');
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
        $TotalPenjualan=0;
        $TotalPiutangusaha=0;
        $TotalSerbaserbi=0;
        $Totaldiscount=0;

        

        // month and year
        $dateYear=strtotime($request->month);
        $month=date("m",$dateYear);
        $year=date("Y",$dateYear);

        $data_sales =[];
        $data_sales_id =[];
        $id=NULL;

        $cash = DB::table('jurnal_lines')
        ->join('invoices', 'jurnal_lines.invoice_id', '=', 'invoices.id')
        ->join('partners', 'invoices.partner_id', '=', 'partners.id')
        ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        ->join('payments', 'jurnal_lines.payment_id', '=', 'payments.id')
        ->select('payments.amount', 'partners.name', 'jurnals.transaction_date','jurnal_lines.id','partners.id', 'jurnal_lines.description')
        // ->where('invoices.type', '=', 'sale')
        // ->where('invoices.state', '=', 'done')
        ->where('credit', '>', 0)
        ->where('akun_id', '=', 4)
        ->whereMonth('jurnals.transaction_date', $month)
        ->whereYear('jurnals.transaction_date', $year)
        ->get();


    for ($i=0; $i<count($cash); $i++){
        $id =(string)$cash[$i]->id;
        $a =in_array($id, $data_sales_id);
        // if ($a == false){
            $data_sales_id[] = (string)$cash[$i]->id;
            $data_sales[] = $cash[$i];
            end($data_sales)->cash = 0;
            end($data_sales)->grand_total = 0;
            $TotalKas += $cash[$i]->amount;
            
        // }
        // else{
        //     $key= array_search($id, $data_sales_id); 
        //     $amount =$data_sales[$key]->cash + $cash[$i]->amount;
        //     $data_sales[$key]->cash = $amount;
        //     $TotalKas += $cash[$i]->amount;
        // }
    }
   
        $sales = DB::table('jurnal_lines')
            ->join('invoices', 'jurnal_lines.invoice_id', '=', 'invoices.id')
            ->join('partners', 'invoices.partner_id', '=', 'partners.id')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->select('invoices.grand_total', 'partners.name', 'jurnals.transaction_date','partners.id', 'jurnal_lines.description')
            // ->where('invoices.type', '=', 'sale')
            // ->where('invoices.state', '=', 'done')
            // ->where('payment_id', '=', NULL)
            ->where('debit', '>', 0)
            ->where('akun_id', '=', 4)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->get();

        
        for ($i=0; $i<count($sales); $i++){
            $id =(string)$sales[$i]->id;
            $a =in_array($id, $data_sales_id);
            // if ($a == false){
                $data_sales_id[] = (string)$sales[$i]->id;
                $data_sales[] = $sales[$i];
                end($data_sales)->cash = 0;
                end($data_sales)->amount = 0;
                $TotalPenjualan += $sales[$i]->grand_total;
            // }
            // else{
            //     $key= array_search($id, $data_sales_id); 
            //     $amount =$data_sales[$key]->grand_total + $sales[$i]->grand_total;
            //     $data_sales[$key]->grand_total = $amount;
            //     $TotalPenjualan += $sales[$i]->grand_total;
            // }
        }

       
        $data_sales = Arr::sort($data_sales, function($data)
        {
            return $data->transaction_date;
        });

        


        $pdf = PDF::loadview('penerimaan-kas.laporan',
            [
                'cash' => $cash,
                'sales' => $data_sales,
                'TotalKas' => $TotalKas,
                'TotalPenjualan' => $TotalPenjualan,
                'TotalPiutangusaha' => $TotalPiutangusaha,
                'TotalSerbaserbi' => $TotalSerbaserbi,
                'Totaldiscount' => $Totaldiscount,
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
            ]
        );
        return $pdf->stream('laporan-penerimaan-kas-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
