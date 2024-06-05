<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle_id', 'barcode', 'current_section', 'status'
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function trackings()
    {
        return $this->hasMany(Tracking::class);
    }
}
