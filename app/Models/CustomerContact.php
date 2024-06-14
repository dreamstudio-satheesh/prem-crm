<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    use HasFactory;

    protected $table = 'customer_contacts';

    protected $primaryKey = 'customer_contact_id';

    protected $fillable = [
        'customer_id', 'contact_id', 'role'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'contact_id');
    }
}
