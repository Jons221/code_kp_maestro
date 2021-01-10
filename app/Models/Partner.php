<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'phone', 'email','address', 'remark'];

    public static function rules($merge = [])
    {
        return array_merge(
            [
                'name' => 'required',
                'phone' => 'nullable',
                'email' => 'required',
                'address' => 'nullable',
                'remark' => 'nullable',
            ],
            $merge
        );
    }

    public function purchase(){
        return $this->hasMany(Purchase::class);
    }

    protected static function boot(){
        parent::boot();

        static::deleting(function($supplier){
            foreach($supplier->purchase()->get() as $purchase){
                $purchase->delete();
            }
        });
    }
}
