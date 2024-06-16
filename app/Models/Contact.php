<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'name',
        'email',
        'address',
        'company',
        'notes',
        'position_id',
        'user_id',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'position_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function phones()
    {
        return $this->hasMany(ContactPhone::class, 'contact_id', 'contact_id');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_contacts', 'contact_id', 'customer_id');
    }
}
