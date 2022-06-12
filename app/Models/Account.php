<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'is_entry',
        'detail',
        'ammount',
        'client_user_id',
        'store_id',
        'administrator_user_id',

    ];

    public function scopeClientUser($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('client_user_id',$id); }
    }
    public function scopeStore($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('store_id',$id); }
    }
    public function scopeAdministratorUser($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('administrator_user_id',$id); }
    }

}
