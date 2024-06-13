<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'name', 'phone', 'email', 'address', 'company', 'designation', 'notes', 'user_id'
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_contacts')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
