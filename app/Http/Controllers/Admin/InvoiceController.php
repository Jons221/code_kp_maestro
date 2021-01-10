<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice as Invoices;
use App\Models\Invoice_lines;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Marking;
use App\Models\Supplier;
use App\Models\Item;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\OrderStatus;
use DB;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Carbon\Carbon;
use App\Models\Jurnal;
use App\Models\Akun;
use App\Models\JurnalDetail;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::all();
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carbon= Carbon::now();
        $invoice = Invoices::whereYear('created_at', $carbon->year)->count();
        if ($invoice == 0){
          $invoice = 1;
        }
        else{
          $invoice += 1;
        }
        $pc = 'INV'.$carbon->year.'-'.$invoice;
        return view('invoice.form', compact('pc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate(Invoices::rules());
      try {
        DB::beginTransaction();
        $quantity = $request->input('lines');
        $left_payment=$request->input('grand_total');
        $state="draft";
        $invoice = Invoices::create(array_merge($request->except(['quantity', 'product_name']), ['left_payment' => $left_payment, 'state' => $state]));
        $invoice_lines = [];
        // for($i = 0; $i < count($product_id); $i++) {
        //   $subTotal = $product_id[$i] * $quantity[$i];
        //   $purchaseDetail[] = [
        //     'product_id' => $product_id[$i],
        //     'purchase_id' => $purchase->id,
        //     'quantity' => $quantity[$i],
        //     'sub_total' => $subTotal,
        //   ];
        // }
        
        foreach ($quantity as $key => $value) {
          $invoice_lines[] = [
            'invoice_id' => $invoice->id,
            'product_name' => $value['product_name'],
            'quantity' => $value['quantity'],
            'uom' => $value['uom'],
            'sub_total' => $value['sub_total'],
            'price' => $value['unit_price']
          ];
        }

        // DB::table('invoice_lines')->insert($invoice_lines);
        $invoice->invoice_lines()->createMany($invoice_lines);
        DB::commit();
        return redirect()->route('invoices.index')->with('status', 'New item successfully added');
      } catch (\Throwable $th) {
        DB::rollback();
        return redirect()->route('invoices.index')->with('error', 'Fail to add item, please try again!');
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices $invoice)
    {
        $invoice = Invoices::find($invoice->id);
        $payments = Payment::where('invoice_id','=',$invoice->id)->get();
        $invoiceItems = Invoice_lines::where('invoice_id','=', $invoice->id)->get();
        $productList = [];

        $productIds = [];
        foreach($invoiceItems as $item){
            $productList[] = [
              'product_name' => $item->product_name,
              'quantity' => $item->quantity,
              'price' => $item->price,
              'uom' => $item->uom,
              'sub_total' => $item->sub_total,
            ];
        }
        // dd($productList);

        // foreach($productIds as $id){
        //   $product = Product::find($id);
        //   $product->variants = $invoiceItems->where('product_id','=', $id);
        //   $productList[] = $product;
        // }

        return view('invoice.show', compact('invoice','payments','productList'));
    }

    
    public function edit(Invoices $invoice)
    {
        $invoice = Invoices::find($invoice->id);
        $invoice->invoice_lines;
        // if($invoice->status == 5){
        //   return redirect()->route('invoices.index')->with('error', 'Completed order not available for edit!'); 
        // }
        // dd($invoice);
        return view('invoice.form', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *

     */
    public function update(Request $request, Invoices $invoice)
    {
        $request->validate(Invoices::rules());
        $currentDetails = Invoices::where('id','=', $invoice->id)->with('invoice_lines')->first()->invoice_lines->toArray();
        $currentDetailIdList = [];
        $newDetailIdList = [];
        $state = $invoice->state;

      
        try{
          DB::beginTransaction();
          $quantity = $quantity = $request->input('lines');
          $left_payment=$request->input('grand_total');

          $invoice->update(array_merge($request->except(['quantity']), ['left_payment' => $left_payment]));
          $invoice->invoice_lines()->delete();

          foreach ($quantity as $key => $value) {
            $newDetail = [
              'invoice_id' => $invoice->id,
              'product_name' => $value['product_name'],
              'quantity' => $value['quantity'],
              'uom' => $value['uom'],
              'sub_total' => $value['sub_total'],
              'price' => $value['unit_price']
            ];

            
            Invoice_lines::create($newDetail);
            

          // foreach ($currentDetails as $currentDetail) {
          //   $currentDetailIdList[] = $currentDetail['product_id'];
          // }

          // foreach ($currentDetailIdList as $currentDetailId) {
          //   if(!in_array($currentDetailId, $newDetailIdList)){
          //     Invoice_lines::where([['purchase_id','=', $purchase->id],['product_id','=', $currentDetailId]])->delete();
          //   }
          }
          DB::commit();
          return redirect()->route('invoices.index')->with('status', 'Data successfully updated');
        }catch(\Throwable $th){
          DB::rollback();
          return redirect()->route('invoices.index')->with('error', 'Fail to update the data, please try again!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $invoice = Invoices::find($id);
        $invoice->invoice_lines()->delete();
        $invoice->delete();
    }

    public function invoiceDataTable(Request $request){
        $data = Invoices::query()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
              $buttonAll = '
              <div class="d-flex flex-row justify-content-center">
                <div class="dropdown mr-2">
                  <button class="btn btn-primary btn-rounded btn-sm dropdown-toggle" type="button" id="optionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                  </button>
                  <div class="dropdown-menu" aria-labelledby="optionMenu">
                    <button class="dropdown-item" type="button" id="show-detail" data-id='.$data->id.'>Show</button>
                  </div>
                </div>';
              if ($data->state =='draft') {
                $buttonAll = '
              <div class="d-flex flex-row justify-content-center">
                <div class="dropdown mr-2">
                  <button class="btn btn-primary btn-rounded btn-sm dropdown-toggle" type="button" id="optionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                  </button>
                  <div class="dropdown-menu" aria-labelledby="optionMenu">
                    <button class="dropdown-item" type="button" id="update-status" data-id='.$data->id.'>Confirm</button>
                    <button class="dropdown-item" type="button" id="show-detail" data-id='.$data->id.'>Show</button>
                    <button class="dropdown-item" type="button" id="edit" data-id='.$data->id.'>Edit</button>
                    <button class="dropdown-item" type="button" id="delete" data-id='.$data->id.'>Delete</button>
                  </div>
                </div>';
              } 
              if ($data->state =='confirm') {
                $buttonAll = '
              <div class="d-flex flex-row justify-content-center">
                <div class="dropdown mr-2">
                  <button class="btn btn-primary btn-rounded btn-sm dropdown-toggle" type="button" id="optionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                  </button>
                  <div class="dropdown-menu" aria-labelledby="optionMenu">
                    
                    <button class="dropdown-item" type="button" id="show-detail" data-id='.$data->id.'>Show</button>
                    <button class="dropdown-item" type="button" id="delete" data-id='.$data->id.'>Delete</button>
                  </div>
                </div>';
              } 
              return $buttonAll;
            })
            ->rawColumns(['action'])
            ->make(true);
      }

      public function duplicateOrder($id){
       try {
          $currentOrder = Invoices::find($id);
          $invoiceDetails = $currentOrder->invoiceDetail()->get();
          $newOrder = $currentOrder->replicate();
          $newOrder->code = 'INV'.date('YmdHis');
          $newOrder->order_date = date('Y-m-d');
          $newOrder->status = 1;
          DB::beginTransaction();
          $newOrder->save();

          $newInvoiceDetails = [];
          foreach ($invoiceDetails as $pd) {
            $newinvoiceDetails[] = [
              'invoice_id' => $newOrder->id,
              'product_name' => $pd->product_name,
              'quantity' => $pd->quantity,
              'uom' => $pd->uom,
              'price' => $pd->unit_price,
              'sub_total' => $pd->sub_total
            ];
          }
          DB::table('invoice_lines')->insert($newInvoiceDetails);
          DB::commit();
        } catch (\Throwable $th) {
          DB::rollback();
        }
        return response()->json(['status', 'success']);
      }

      public function invoiceselect(Request $request){
        $term = trim($request->q);
        if(empty($term)){
            return response()->json([]);
        }
    
        $invoices = Invoice::select('id','number')->where('number', 'like', '%' .$term . '%')->limit(20)->get();
    
        $formattedOrders= [];
        foreach($invoices as $invoice){
            $formattedOrders[] = ['id'=>$invoice->id, 'text'=>$invoice->number];
        }
    
        return response()->json($formattedOrders);
     }

     public function getInvoiceDetails($id){
       $invoiceDetails = InvoiceDetail::where('invoice_id', '=', $id)->get();
       return response()->json($invoiceDetails);
     }

    //  public function countBadge(){
    //   $invoices = Purchase::all();
    //   $waiting = count($invoices->where('status', 1));
    //   $warehouse = count($invoices->where('status', 2));
    //   $indonesia = count($invoices->where('status', 3));
    //   $arrived = count($invoices->where('status', 4));
    //   $completed = count($invoices->where('status', 5));
    //   return response()->json([
    //     'waiting'=> $waiting, 
    //     'warehouse' => $warehouse, 
    //     'indonesia' => $indonesia,
    //     'arrived' => $arrived,
    //     'completed' => $completed
    //   ]);
    //  }

     public function totalPayment($id){
       $total = Invoices::find($id)->grand_total;
       return response()->json(['total' => $total]);
     }

     public function invoice($id){
      $invoice = Invoices::find($id);
      $invoiceDetail = Partner::find($invoice->partner_id);
      $invoice = new Party([
        'name' => $invoiceDetail->name,
        'phone' => $invoiceDetail->phone,
        'address' => $invoiceDetail->address,
      ]);
      $buyer = new Party([
        'name' => 'Admin'
      ]);
      $invoiceDetail = $invoice->invoiceDetail;
      
      $items = [];
      foreach($invoice->invoiceDetail as $detail => $value) {
        $productName = Product::find($value->product_id)->name;
        $items[] = (new InvoiceItem())->title($productName)->pricePerUnit(floatval($value->sub_total))->quantity($value->quantity);
      }

      $invoice = Invoice::make()
        ->name('Invoice')
        ->seller($partner)
        ->buyer($partner)
        ->currencySymbol('Rp.')
        ->currencyCode('IDR')
        ->currencyFormat('{SYMBOL}{VALUE}')
        ->addItems($items)
        ->template('invoice');

      return $invoice->stream();
     }

     public function updateStatus(Request $request){
      $id = $request->input('id');
      $state = $request->input('state');

      $invoice = Invoices::find($id);
      $amount = $invoice->grand_total;
      // if($invoice->state == 'draft'){
      //   return response()->json(['error' => 'Can not update completed order']);
      // }
      $carbon= Carbon::now();
      $journal_num = Jurnal::whereYear('created_at', $carbon->year)->count();
      if ($journal_num == 0){
        $journal_num = 1;
      }
      else{
        $journal_num += 1;
      }
      $journal_num_Str = 'Journal'.$carbon->year.'-'.$journal_num;
      $journal = Jurnal::create([
        'transaction_no'=>$journal_num_Str,
        'transaction_date'=>$carbon,
        'total_debit'=>$amount,
        'total_credit'=>$amount,
      ]);
      if ($invoice->type == 'sale'){
        $sales = Akun::select('id')->where('code', '4')->limit(1)->first();
        $receivable = Akun::select('id')->where('code', '1.1.2')->limit(1)->first();
        JurnalDetail::create([
          'jurnal_id'=>$journal->id,
          'akun_id'=>$receivable->id,
          'description'=>$invoice->number,
          'invoice_id'=>$invoice->id,
          'payment_id'=>NULL,
          'debit'=>$amount,
          'credit'=>0,
        ]);
        JurnalDetail::create([
          'jurnal_id'=>$journal->id,
          'akun_id'=>$sales->id,
          'description'=>$invoice->number,
          'invoice_id'=>$invoice->id,
          'payment_id'=>NULL,
          'debit'=>0,
          'credit'=>$amount,
        ]);
      }
      if ($invoice->type == 'purchase'){
        $purchase = Akun::select('id')->where('code', '5')->limit(1)->first();
        $payable = Akun::select('id')->where('code', '2.1.1')->limit(1)->first();
        JurnalDetail::create([
          'jurnal_id'=>$journal->id,
          'akun_id'=>$payable->id,
          'description'=>$invoice->number,
          'invoice_id'=>$invoice->id,
          'payment_id'=>NULL,
          'debit'=>0,
          'credit'=>$amount,
        ]);
        JurnalDetail::create([
          'jurnal_id'=>$journal->id,
          'akun_id'=>$purchase->id,
          'description'=>$invoice->number,
          'invoice_id'=>$invoice->id,
          'payment_id'=>NULL,
          'debit'=>$amount,
          'credit'=>0,
        ]);
      }
      $invoice->state = $state;
      $invoice->save();

      return response()->json();
    }

    public function createPayment(Request $request){
      $id = $request->input('id');
      $amount = floatval($request->input('amount'));
      $message=NULL;
      $invoice = Invoices::find($id);
      $number = 'PAY'.date('YmdHis');
      if ($amount>$invoice->left_payment){
        $left_amount_remaind=$invoice->left_payment;
        $message="Left Payment sisa ".$left_amount_remaind;
      }
      else{
        if ($invoice->left_payment > 0){
          $carbon= Carbon::now();
          $payment_num = Payment::whereYear('created_at', $carbon->year)->count();
          if ($payment_num == 0){
            $payment_num = 1;
          }
          else{
            $payment_num += 1;
          }
          $journal_num = Jurnal::whereYear('created_at', $carbon->year)->count();
          if ($journal_num == 0){
            $journal_num = 1;
          }
          else{
            $journal_num += 1;
          }
          $payment_num_Str = 'Pay'.$carbon->year.'-'.$payment_num;
          $journal_num_Str = 'Journal'.$carbon->year.'-'.$journal_num;
          $payment =Payment::create([
            'number'=>$payment_num_Str,
            'partner_id'=>$invoice->partner_id,
            'invoice_id'=>$id,
            'type'=>$invoice->type,
            'amount'=>$amount,
          ]);
          $journal = Jurnal::create([
            'transaction_no'=>$journal_num_Str,
            'transaction_date'=>$carbon,
            'total_debit'=>$amount,
            'total_credit'=>$amount,
          ]);
          if ($invoice->type == 'sale'){
            $cash = Akun::select('id')->where('code', '1.1.1')->limit(1)->first();
            $receivable = Akun::select('id')->where('code', '1.1.2')->limit(1)->first();
            JurnalDetail::create([
              'jurnal_id'=>$journal->id,
              'akun_id'=>$cash->id,
              'invoice_id'=>$invoice->id,
              'payment_id'=>$payment->id,
              'debit'=>$amount,
              'credit'=>0,
            ]);
            JurnalDetail::create([
              'jurnal_id'=>$journal->id,
              'akun_id'=>$receivable->id,
              'invoice_id'=>$invoice->id,
              'payment_id'=>$payment->id,
              'debit'=>0,
              'credit'=>$amount,
            ]);
            
          }
          if ($invoice->type == 'purchase'){
            $cash = Akun::select('id')->where('code', '1.1.1')->limit(1)->first();
            $payable = Akun::select('id')->where('code', '2.1.1')->limit(1)->first();
            JurnalDetail::create([
              'jurnal_id'=>$journal->id,
              'akun_id'=>$payable->id,
              'invoice_id'=>$invoice->id,
              'payment_id'=>$payment->id,
              'debit'=>$amount,
              'credit'=>0,
            ]);
            JurnalDetail::create([
              'jurnal_id'=>$journal->id,
              'akun_id'=>$cash->id,
              'invoice_id'=>$invoice->id,
              'payment_id'=>$payment->id,
              'debit'=>0,
              'credit'=>$amount,
            ]);
            
          }
          
          $invoice->left_payment-= $amount;
          $invoice->save();
        }
        
        if ($invoice->left_payment == 0){
          $invoice->state = 'done';
          $invoice->save();
        }
      }
      
      if ($message != Null){
        return response()->json([
          'message'=>$message,
        ]);
      }
      return response()->json();
    }
}
