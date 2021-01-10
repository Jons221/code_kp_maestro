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

class PengeluarankasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pengeluaran-kas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {

        $TotalKas= 0;
        $TotalPurchase=0;
        $TotalPiutangusaha=0;
        $TotalSerbaserbi=0;
        $Totaldiscount=0;
        $totalpengeluaran=0;

        

        // month and year
        $dateYear=strtotime($request->month);
        $month=date("m",$dateYear);
        $year=date("Y",$dateYear);

        $purchase = DB::table('jurnal_lines')
            ->join('invoices', 'jurnal_lines.invoice_id', '=', 'invoices.id')
            ->join('partners', 'invoices.partner_id', '=', 'partners.id')
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->select('invoices.grand_total', 'partners.name', 'jurnals.transaction_date','partners.id', 'jurnal_lines.debit','jurnal_lines.credit','jurnal_lines.description')
            ->where('invoices.type', '=', 'purchase')
            ->where('invoices.state', '=', 'done')
            ->where('payment_id', '=', NULL)
            ->where('akun_id', '=', 21)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->get();

        $data_sales =[];
        $data_sales_id =[];
        $id=NULL;
        for ($i=0; $i<count($purchase); $i++){
            $id =(string)$purchase[$i]->id;
            $a =in_array($id, $data_sales_id);
            // if ($a == false){
                $data_sales_id[] = (string)$purchase[$i]->id;
                $data_sales[] = $purchase[$i];
                $amount =$purchase[$i]->credit - $purchase[$i]->debit;
                end($data_sales)->amount = $amount;
                end($data_sales)->total_other = 0;
                end($data_sales)->kas = $amount;
                $TotalPurchase += $purchase[$i]->grand_total;
                $totalpengeluaran += $amount;
            // }
            // else{
            //     $key= array_search($id, $data_sales_id); 
            //     $amount =$data_sales[$key]->grand_total + $purchase[$i]->grand_total;
            //     $data_sales[$key]->grand_total = $amount;
            //     $TotalPurchase += $purchase[$i]->grand_total;
            // }
        }

        
        // $cash = DB::table('jurnal_lines')
        //     ->join('invoices', 'jurnal_lines.invoice_id', '=', 'invoices.id')
        //     ->join('partners', 'invoices.partner_id', '=', 'partners.id')
        //     ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
        //     ->join('payments', 'jurnal_lines.payment_id', '=', 'payments.id')
        //     ->select('payments.amount', 'partners.name', 'jurnals.transaction_date','jurnal_lines.id','partners.id')
        //     ->where('invoices.type', '=', 'purchase')
        //     ->where('invoices.state', '=', 'done')
        //     ->where('akun_id', '=', 3)
        //     ->whereMonth('jurnals.transaction_date', $month)
        //     ->whereYear('jurnals.transaction_date', $year)
        //     ->get();

        // for ($i=0; $i<count($cash); $i++){
        //     $id =(string)$cash[$i]->id;
        //     $a =in_array($id, $data_sales_id);
        //     // if ($a == false){
        //         $data_sales_id[] = (string)$cash[$i]->id;
        //         $data_sales[] = $cash[$i];
        //         end($data_sales)->amount = 0;
        //         end($data_sales)->total_other = 0;
        //         $TotalKas += $cash[$i]->amount;
        //     // }
        //     // else{
        //     //     $key= array_search($id, $data_sales_id); 
        //     //     $amount =$data_sales[$key]->amount + $cash[$i]->amount;
        //     //     $data_sales[$key]->amount = $amount;
        //     //     $TotalKas += $cash[$i]->amount;
        //     // }
        // }

        $other_exp = DB::table('jurnal_lines')
            ->select('jurnal_lines.description', 'jurnal_lines.debit', 'jurnal_lines.credit','jurnals.transaction_date','jurnal_lines.description' )
            ->join('jurnals', 'jurnal_lines.jurnal_id', '=', 'jurnals.id')
            ->where('akun_id', 55)
            ->whereMonth('jurnals.transaction_date', $month)
            ->whereYear('jurnals.transaction_date', $year)
            ->get();
        
        for ($i=0; $i<count($other_exp); $i++){
            $data_sales_id[] = false;
            $amount = $other_exp[$i]->debit - $other_exp[$i]->credit;
            $data_sales[] = $other_exp[$i];
            end($data_sales)->amount = 0;
            end($data_sales)->grand_total = 0;
            end($data_sales)->total_other = $amount;
            end($data_sales)->name = $other_exp[$i]->description;
            end($data_sales)->kas = $amount;
            end($data_sales)->transaction_date = $other_exp[$i]->transaction_date;
            // $data_sales[]= ['total_other'=>$amount, 'name'=>$other_exp[$i]->description, 'transaction_date'=>$other_exp[$i]->transaction_date,];
            $TotalSerbaserbi += $amount;
            $totalpengeluaran += $amount;
        }

        $data_sales = Arr::sort($data_sales, function($data)
        {
            return $data->transaction_date;
        });

        $pdf = PDF::loadview('pengeluaran-kas.laporan',
            [
                'purchase' => $data_sales,
                'TotalKas' => $TotalKas,
                'TotalPurchase' => $TotalPurchase,
                'TotalPiutangusaha' => $TotalPiutangusaha,
                'TotalSerbaserbi' => $TotalSerbaserbi,
                'Totaldiscount' => $Totaldiscount,
                'totalpengeluaran' => $totalpengeluaran,
                'reportMonthYear' => 'Laporan Bulan '. $month . ' Tahun ' . $year,
            ]
        );
        return $pdf->stream('laporan-pengeluaran-kas-'.$request->month.'.pdf');
        // return $pdf->donwload('laporan-laba-rugi-'.$request->month.'.pdf');
    }
}
