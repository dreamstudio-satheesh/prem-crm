<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'contact_info', 'address'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'customer_contacts')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
