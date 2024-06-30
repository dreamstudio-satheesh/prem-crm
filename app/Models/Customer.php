<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'amc_id',
        'product_id',
        'amc',
        'tss_status',
        'tss_adminemail',
        'tss_expirydate',
        'profile_status',
        'staff_id',
        'remarks',
        'primary_address_id',
        'default_customer_type_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if (!$customer->default_customer_type_id) {
                // Assuming '1' is the ID for the 'owner' address type in addresstypes table
                $customer->default_customer_type_id = 1;
            }
        });
    }

    public function primaryAddress()
    {
        return $this->belongsTo(AddressBook::class, 'primary_address_id', 'address_id');
    }

    public function addressBooks()
    {
        return $this->hasMany(Addressbook::class, 'customer_id', 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }


    public function amc()
    {
        return $this->hasOne(Amc::class, 'customer_id', 'customer_id');
    }

    public function addresses()
    {
        return $this->belongsTo(AddressBook::class, 'customer_id', 'customer_id');
    }


}
