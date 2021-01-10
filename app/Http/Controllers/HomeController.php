<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Payment;
Use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dateYear=Carbon::now()->format('Y');
        $dateMonth=Carbon::now()->format('m');
        
        $sales_done = Invoice::where('type', 'sale')
            ->whereMonth('created_at', $dateMonth)
            ->whereYear('created_at', $dateYear)
            ->where('state', 'done')
            ->sum(DB::raw('grand_total'));

        $sales_confirm = Invoice::where('type', 'sale')
            ->whereMonth('created_at', $dateMonth)
            ->whereYear('created_at', $dateYear)
            ->where('state', 'confirm')
            ->sum(DB::raw('grand_total'));

        $sales_draft = Invoice::where('type', 'sale')
            ->whereMonth('created_at', $dateMonth)
            ->whereYear('created_at', $dateYear)
            ->where('state', 'draft')
            ->sum(DB::raw('grand_total'));

        $purchase_done = Invoice::where('type', 'purchase')
            ->whereMonth('created_at', $dateMonth)
            ->whereYear('created_at', $dateYear)
            ->where('state', 'done')
            ->sum(DB::raw('grand_total'));

        $purchase_confirm = Invoice::where('type', 'purchase')
            ->whereMonth('created_at', $dateMonth)
            ->whereYear('created_at', $dateYear)
            ->where('state', 'confirm')
            ->sum(DB::raw('grand_total'));

        $purchase_draft = Invoice::where('type', 'purchase')
            ->whereMonth('created_at', $dateMonth)
            ->whereYear('created_at', $dateYear)
            ->where('state', 'draft')
            ->sum(DB::raw('grand_total'));

        $payment_sales = Payment::where('type', 'sale')
            ->whereMonth('created_at', $dateMonth)
            ->whereYear('created_at', $dateYear)
            ->sum(DB::raw('amount'));

        $payment_purchase = Payment::where('type', 'purchase')
            ->whereMonth('created_at', $dateMonth)
            ->whereYear('created_at', $dateYear)
            ->sum(DB::raw('amount'));


        // $product = count(Product::all());
        $partner = count(Partner::all());
        $payment = Invoice::all()->sum('grand-total');
        return view('home', compact('partner', 'payment', 'sales_done', 'sales_confirm', 'sales_draft', 'purchase_done', 'purchase_confirm', 'purchase_draft', 'payment_sales', 'payment_purchase'));
    }
}
