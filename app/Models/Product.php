<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Product extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'id', 'description', 'name', 'price', 'quantity', 
        'type'
    ];

    protected function getall()
    {
        return DB::table('products')            
                ->select('id','name')  
                ->orderBy('name', 'asc')             
               ->get();    
  
        
      }
}
