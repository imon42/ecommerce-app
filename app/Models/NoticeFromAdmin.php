<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeFromAdmin extends Model
{
    protected $fillable =[
        'notice'
    ];

    protected $hidden =[
        'created_at',
        'updated_at',
    ];
}
