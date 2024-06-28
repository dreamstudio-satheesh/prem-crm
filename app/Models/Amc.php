<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amc extends Model
{
    use HasFactory;

    protected $table = 'amc';

    protected $fillable = [
        'customer_id', 
        'amc_from_date', 
        'amc_to_date', 
        'amc_renewal_date', 
        'no_of_visits', 
        'amc_amount', 
        'amc_last_year_amount'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

