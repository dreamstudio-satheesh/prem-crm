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
        'tally_serial_no',
        'licence_editon',
        'primary_address_id',
        'product_id',
        'location_id',
        'staff_id',
        'amc_id',
        'amc',
        'tss_status',
        'tss_adminemail',
        'tss_expirydate',
        'profile_status',
        'remarks',
        'whatsapp_telegram_group',
        'tdl_addons',
        'auto_backup',
        'cloud_user',
        'mobile_app',
        'gst_no',
        'map_location',
        'latitude',
        'longitude',
        'status',
    ];

    public static function boot()
    {
        parent::boot();

       /*  static::creating(function ($customer) {
            if (!$customer->default_customer_type_id) {
                $customer->default_customer_type_id = 1;
            }
        }); */
    }

    public function primaryAddress()
    {
        return $this->belongsTo(AddressBook::class, 'primary_address_id', 'address_id');
    }

    public function AddressBooks()
    {
        return $this->hasMany(AddressBook::class, 'customer_id', 'customer_id');
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
