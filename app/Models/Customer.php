<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['customer_id'];

    protected $primaryKey = 'customer_id';

     protected $fillable = [
        'customer_name', 
    ];  
   
  
    protected function getall()
    {
        return DB::table('customers')            
                ->LeftJoin('users', 'users.id', '=', 'customers.staff_id')
                ->select('customeraddress_id','customer_id','customer_name','amc','tss_status','remarks','users.name as staffname')  
                ->orderBy('customer_name', 'asc')             
                 ->paginate(10);   
      }
    
}
