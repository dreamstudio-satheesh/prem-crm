<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addressbook extends Model
{
    use HasFactory;
   
    protected $table = 'addressbook'; 

    protected $primaryKey = 'idd';
 
    protected $fillable = [
        'id', 'idd', 'customer_code', 'addresstype', 'indx', 
        'contact_person', 'mobileno', 'phoneno', 'email' 
    ];
}
