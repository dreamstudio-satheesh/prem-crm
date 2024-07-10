<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileNumber extends Model
{
    use HasFactory;

    protected $fillable = ['address_id', 'mobile_no'];
}
