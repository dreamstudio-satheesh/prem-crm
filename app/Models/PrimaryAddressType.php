<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryAddressType extends Model
{
    use HasFactory;

    protected $fillable = ['primary_id', 'secondary_id'];
}
