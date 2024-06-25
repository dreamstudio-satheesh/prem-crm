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
        'product_id',
        'amc',
        'tss_status',
        'tss_adminemail',
        'tss_expirydate',
        'profile_status',
        'staff_id',
        'remarks',
        'customer_address_id'
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public static function getAll()
    {
        return self::leftJoin('users', 'users.id', '=', 'customers.staff_id')
            ->select('customeraddress_id', 'customer_id', 'customer_name', 'amc', 'tss_status', 'remarks', 'users.name as staffname')
            ->orderBy('customer_name', 'asc')
            ->paginate(10);
    }
}
