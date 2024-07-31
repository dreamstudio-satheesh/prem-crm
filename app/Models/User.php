<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use DB;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['username','name', 'email', 'password', 'role_id'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower(str_replace(' ', '', $value));
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    protected function getall()
    {
        return DB::table('users')            
                ->select('id','name')  
                ->orderBy('name', 'asc')             
               ->get();    
      }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'customer_contacts')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}