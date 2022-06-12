<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class System extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'admin_version',
        'client_version',
        'qr',

    ];


}
