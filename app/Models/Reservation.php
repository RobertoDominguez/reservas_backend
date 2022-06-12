<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'user_name',
        'date',
        'time',
        'accepted',
        'rejected',
        'message',
        'image',
        'store_id',
        'service_id',
        'client_user_id',

    ];

    public function scopeStore($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('store_id',$id); }
    }
    public function scopeService($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('service_id',$id); }
    }
    public function scopeClientUser($query,$id){
      if (is_null($id)) { return $query; }else{ return $query->where('client_user_id',$id); }
    }

}
