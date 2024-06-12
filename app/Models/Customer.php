<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['customer_id'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'customer_contacts')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
