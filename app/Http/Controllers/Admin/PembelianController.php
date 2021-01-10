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

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        // return Excel::download(new LabaRugiExport($request->month), 'laba-rugi.xlsx');

        $TotalAP= 0;
        $TotalPurchase=0;
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

        $purchase = DB::table('jurnal_lines')
            ->join('invoices', 'jurnal_lines.invoice_id', '=', 'invoices.id')
            ->join('partners', 'invoices.partner_id', '=', 'partners.id')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->select('debit', 'partners.name', 'jurnals.transaction_date','partners.id', 'jurnal_lines.description')
            // ->where('invoices.type', '=', 'sale')
            // ->where('invoices.state', '=', 'done')
            // ->where('payment_id', '=', NULL)
            ->where('debit', '>', 0)
            ->where('akun_id', '=', 32)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->get();
        
        for ($i=0; $i<count($purchase); $i++){
            $id =(string)$purchase[$i]->id;
            $a =in_array($id, $data_sales_id);

            // $data_sales_id[] = (string)$purchase[$i]->id;
            $data_sales[] = $purchase[$i];
            end($data_sales)->AP = 0;
            end($data_sales)->purchase = $purchase[$i]->debit;
            $TotalPurchase += $purchase[$i]->debit;
           
        }

        $acc_ap = DB::table('jurnal_lines')
        ->join('invoices', 'jurnal_lines.invoice_id', '=', 'invoices.id')
        ->join('partners', 'invoices.partner_id', '=', 'partners.id')
        ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        ->select('jurnal_lines.credit', 'partners.name', 'jurnals.transaction_date','partners.id', 'jurnal_lines.description')
        ->where('credit', '>', 0)
        ->where('akun_id', '=', 21)
        ->whereMonth('jurnals.transaction_date', $month)
        ->whereYear('jurnals.transaction_date', $year)
        ->get();

        for ($i=0; $i<count($acc_ap); $i++){
            $id =(string)$acc_ap[$i]->id;
            $a =in_array($id, $data_sales_id);
            // if ($a == false){
                $data_sales_id[] = (string)$acc_ap[$i]->id;
                $data_sales[] = $acc_ap[$i];
                end($data_sales)->purchase = 0;
                end($data_sales)->AP = $acc_ap[$i]->credit;
                $TotalAP += $acc_ap[$i]->credit;
                
            // }
            // else{
            //     $key= array_search($id, $data_sales_id); 
            //     $amount =$data_sales[$key]->cash + $acc_ap[$i]->amount;
            //     $data_sales[$key]->cash = $amount;
            //     $TotalAP += $acc_ap[$i]->amount;
            // }
        }
   
        

       
        $data_sales = Arr::sort($data_sales, function($data)
        {
            return $data->transaction_date;
        });

        


        $pdf = PDF::loadview('pembelian.laporan',
            [
                'sales' => $data_sales,
                'TotalAP' => $TotalAP,
                'TotalPurchase' => $TotalPurchase,
                'TotalPiutangusaha' => $TotalPiutangusaha,
                'TotalSerbaserbi' => $TotalSerbaserbi,
                'Totaldiscount' => $Totaldiscount,
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
            ]
        );
        return $pdf->stream('laporan-pembelian-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
