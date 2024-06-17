<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customertype extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'customertype'; 
    protected $fillable = [
        'name',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'id', 'id');
    }
}
