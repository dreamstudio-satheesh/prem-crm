<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NatureOfIssue extends Model
{
    use HasFactory;

    protected $table = 'nature_of_issues';

    protected $fillable = ['name', 'description'];
}
