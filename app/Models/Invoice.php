<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'number', 'type','order_date', 'grand_total', 'partner_id', 'remarks', 'left_payment', 'state'
      ];
    
    public static function rules($merge = [])
    {
      return array_merge(
        [
          'number' => 'required',
          'type' => 'required',
          'order_date' => 'required|date',
          'grand_total' => 'required|numeric|min:0',
          'partner_id' => 'required',
        ],
        $merge
      );
    }
  
    public static function getMarkingName($id){
      try {
        return Marking::find($id)->name;
      } catch (\Throwable $th) {
        return "Marking was delete from the list";
      }
    }
  
    public static function getItemName($id){
      try {
        return Item::find($id)->name;
      } catch (\Throwable $th) {
        return "Item was delete from the list";
      }
    }

    public static function getPartnerName($id){
      try {
        return Partner::find($id)->name;
      } catch (\Throwable $th) {
        return "Item was delete from the list";
      }
    }

    public static function getProductVariantName($id){
      try {
        return ProductVariant::find($id)->name;
      } catch (\Throwable $th) {
        return "Item was delete from the list";
      }
    }

    public function payment(){
      return $this->hasMany(Payment::class);
    }

    public function invoice_lines(){
      return $this->hasMany(Invoice_lines::class);
    }

    public function partner(){
      return $this->hasOne(Partner::class);
    }

    // protected static function boot(){
    //   parent::boot();

    //   static::deleting(function($purchase){
    //     foreach($purchase->payment()->get() as $p){
    //       $p->delete();
    //     }

    //     foreach($purchase->purchaseDetail()->get() as $pd){
    //       $pd->delete();
    //     }
    //   });
    // }

}
