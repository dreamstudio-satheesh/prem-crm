<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'contact_person_id',
        'type_of_call',
        'call_type',
        'call_start_time',
        'call_end_time',
        'follow_up_date',
        'status_of_call',
        'nature_of_issue_id',
        'service_charges',
        'staff_id',
        'remarks',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function contactPerson()
    {
        return $this->belongsTo(AddressBook::class, 'contact_person_id')->with('mobileNumbers');
    }
}
