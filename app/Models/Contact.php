<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_contacts')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
