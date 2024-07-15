<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCallLog extends Model
{
    use HasFactory;


    protected $fillable = ['service_call_id','call_start_time','call_end_time','updated_by'];


    public function serviceCall()
    {
        return $this->belongsTo(ServiceCall::class, 'service_call_id');
    }

}
