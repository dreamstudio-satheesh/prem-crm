<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresstype extends Model
{
    use HasFactory;
   
    protected $table = 'addresstypes'; // Updated table name to plural

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'addresstype_id', 'id'); // Updated relationship keys
    }

    public static function getAll()
    {
        return self::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
    }
}
