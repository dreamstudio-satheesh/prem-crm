<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerContact extends Pivot
{
    use HasFactory;

    protected $table = 'customer_contacts'; 

    protected $primaryKey = 'customer_contact_id';

    protected $fillable = [
        'customer_id',
        'contact_id',
    ];
}
