<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice_lines extends Model
{
    use HasFactory;
    // use SoftDeletes;
  
    protected $fillable = [
        'invoice_id', 'product_name', 'quantity', 'sub_total', 'price', 'uom'
      ];
    
    public static function rules($merge = [])
    {
      return array_merge(
        [
          'purchase_name' => 'required',
          'quantity' => 'required',
        ],
        $merge
      );
    }

    public function invoice(){
      return $this->belongTo(Invoice::class);
  }
}
