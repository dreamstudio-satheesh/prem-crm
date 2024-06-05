<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'section', 'line_id', 'checkpoint_no'
    ];

    public function trackings()
    {
        return $this->hasMany(Tracking::class);
    }
}
