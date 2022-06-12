<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'name',
        'description',
        'duration',
        'price',
        'image',
        'store_id',

    ];

    public function scopeStore($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('store_id',$id); }
    }

}
