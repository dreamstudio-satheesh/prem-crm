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
        'contact_person_mobile_id',
        'type_of_call',
        'call_type',
        'call_details',
        'follow_up_date',
        'call_booking_time',
        'status_of_call',
        'nature_of_issue_id',
        'service_charges',
        'staff_id',
        'created_by',
        'last_active_time',
        'remarks',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function contactPerson()
    {
        return $this->belongsTo(AddressBook::class, 'contact_person_id');
    }

    public function contactPersonMobile()
    {
        return $this->belongsTo(MobileNumber::class, 'contact_person_mobile_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function serviceCallLogs()
    {
        return $this->hasMany(ServiceCallLog::class, 'service_call_id');
    }
}
