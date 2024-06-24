<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Addresstype extends Model
{
    use HasFactory;
   
    protected $table = 'addresstype'; 

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'id', 'id');
    }
    protected function getall()
    {
        return DB::table('addresstype')          
                ->select('id','name')  
                ->orderBy('name', 'asc')             
                ->get();   
      }
    
}
