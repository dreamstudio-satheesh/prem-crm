<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'customer_id', 'product_id', 'amount', 'contact_no',
        'status', 'remarks', 'follow_up_date', 'referral_id', 'referral_name', 
        'referral_contact_no', 'referral_reward'
    ];
}
