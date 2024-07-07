<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnsiteVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'contact_person_id',
        'type_of_call',
        'call_start_time',
        'call_end_time',
        'status_of_call',
        'service_charges',
        'remarks',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function contactPerson()
    {
        return $this->belongsTo(CustomerType::class, 'contact_person_id');
    }
}
