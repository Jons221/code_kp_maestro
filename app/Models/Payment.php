<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['invoice_id', 'type', 'file_name', 'amount','number','partner_id'];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'invoice_id' => 'required',
                'type' => 'required',
                'amount' => 'required|numeric|min:0',
            ],
            $merge
            );
    }

    public function invoice(){
        return $this->belongTo(Invoice::class);
    }

    public static function getPartnerName($id){
        try {
          return Partner::find($id)->name;
        } catch (\Throwable $th) {
          return "Item was delete from the list";
        }
      }

}
