<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'garment_id', 'checkpoint_id', 'timestamp'
    ];

    public function garment()
    {
        return $this->belongsTo(Garment::class);
    }

    public function checkpoint()
    {
        return $this->belongsTo(Checkpoint::class);
    }
}
