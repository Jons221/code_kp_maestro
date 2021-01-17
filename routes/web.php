<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
  Route::resource('invoices', 'App\Http\Controllers\Admin\InvoiceController');
  Route::get('invoice-list/{status}', 'App\Http\Controllers\Admin\InvoiceController@invoiceDataTable');
  Route::get('invoice-select', 'App\Http\Controllers\Admin\InvoiceController@invoiceSelect')->name('invoice-select');
  Route::get('invoices/duplicate/{id}', 'App\Http\Controllers\Admin\InvoiceController@duplicateOrder');
  Route::get('invoices/details/{id}', 'App\Http\Controllers\Admin\InvoiceController@getinvoiceDetails');
  Route::get('invoices-counter', 'App\Http\Controllers\Admin\InvoiceController@countBadge');
  Route::get('invoices-total/{id}', 'App\Http\Controllers\Admin\InvoiceController@totalPayment');
  Route::post('invoices-status','App\Http\Controllers\Admin\InvoiceController@updateStatus');
  Route::post('invoices-payment','App\Http\Controllers\Admin\InvoiceController@createPayment');
  Route::get('invoices/invoice/{id}', 'App\Http\Controllers\Admin\InvoiceController@invoice');

  Route::resource('sales', 'App\Http\Controllers\Admin\SaleController');
  Route::get('sale-list/{status}', 'App\Http\Controllers\Admin\SaleController@saleDataTable');
  Route::get('sale-select', 'App\Http\Controllers\Admin\SaleController@saleSelect')->name('sale-select');
  Route::get('sales/details/{id}', 'App\Http\Controllers\Admin\SaleController@getSaleDetails');

  Route::resource('markings', 'App\Http\Controllers\Admin\MarkingController');
  Route::get('marking-list', 'App\Http\Controllers\Admin\MarkingController@markingDataTable')->name('marking-list');
  Route::get('marking-select', 'App\Http\Controllers\Admin\MarkingController@markingSelect')->name('marking-select');

  Route::resource('products', 'App\Http\Controllers\Admin\ProductController');
  Route::get('product-list', 'App\Http\Controllers\Admin\ProductController@productDataTable')->name('product-list');
  Route::get('product-select', 'App\Http\Controllers\Admin\ProductController@productSelect')->name('product-select');
  Route::get('product/selected/{id}', 'App\Http\Controllers\Admin\ProductController@productSelected');
  Route::get('product/details/{id}', 'App\Http\Controllers\Admin\ProductController@productDetail');

  Route::resource('payments','App\Http\Controllers\Admin\PaymentController');
  Route::get('payment-list', 'App\Http\Controllers\Admin\PaymentController@paymentDataTable')->name('payment-list');
  Route::get('payments/download/{id}', 'App\Http\Controllers\Admin\PaymentController@download');
  Route::get('payments/add-payment/{id}', 'App\Http\Controllers\Admin\PaymentController@addPayment');

  Route::resource('partners', 'App\Http\Controllers\Admin\PartnerController');
  Route::get('partner-list', 'App\Http\Controllers\Admin\PartnerController@partnerDataTable')->name('partner-list');
  Route::get('partner-select', 'App\Http\Controllers\Admin\PartnerController@partnerSelect')->name('partner-select');

  Route::resource('jurnals', 'App\Http\Controllers\Admin\JurnalController');
  Route::get('jurnal-list', 'App\Http\Controllers\Admin\JurnalController@jurnalDataTable')->name('jurnal-list');

  Route::resource('akuns', 'App\Http\Controllers\Admin\AkunController');
  Route::get('akun-list', 'App\Http\Controllers\Admin\AkunController@akunDataTable')->name('akun-list');
  Route::get('akun-select', 'App\Http\Controllers\Admin\AkunController@akunSelect')->name('akun-select');

  Route::get('laba-rugi', 'App\Http\Controllers\Admin\LabaRugiController@index')->name('laba-rugi.index');
  Route::post('laba-rugi', 'App\Http\Controllers\Admin\LabaRugiController@print')->name('laba-rugi.print');

  Route::get('neraca', 'App\Http\Controllers\Admin\NeracaController@index')->name('neraca.index');
  Route::post('neraca', 'App\Http\Controllers\Admin\NeracaController@print')->name('neraca.print');

  Route::get('perubahan_modal', 'App\Http\Controllers\Admin\Perubahan_ModalController@index')->name('perubahan_modal.index');
  Route::post('perubahan_modal', 'App\Http\Controllers\Admin\Perubahan_ModalController@print')->name('perubahan_modal.print');

  Route::get('penjualan', 'App\Http\Controllers\Admin\PenjualanController@index')->name('penjualan.index');
  Route::post('penjualan', 'App\Http\Controllers\Admin\PenjualanController@print')->name('penjualan.print');

  Route::get('penerimaan-kas', 'App\Http\Controllers\Admin\PenerimaankasController@index')->name('penerimaan-kas.index');
  Route::post('penerimaan-kas', 'App\Http\Controllers\Admin\PenerimaankasController@print')->name('penerimaan-kas.print');

  Route::get('pembelian', 'App\Http\Controllers\Admin\PembelianController@index')->name('pembelian.index');
  Route::post('pembelian', 'App\Http\Controllers\Admin\PembelianController@print')->name('pembelian.print');

  Route::get('pengeluaran-kas', 'App\Http\Controllers\Admin\PengeluarankasController@index')->name('pengeluaran-kas.index');
  Route::post('pengeluaran-kas', 'App\Http\Controllers\Admin\PengeluarankasController@print')->name('pengeluaran-kas.print');

}); 