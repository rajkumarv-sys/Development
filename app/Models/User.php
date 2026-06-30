<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Laravel\Passport\HasApiTokens;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User  extends Authenticatable
{
    use HasApiTokens;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $fillable = [
      'name',
      'email',
      'username',
      'password',
      'state_id',
      'sector',
      'lock_lat',
      'lock_long',
      'district_id',
      'catgry_status',
      
    ];

    protected $hidden = [
            'password',
            'remember_token',
        ];
    protected $casts = [
            'email_verified_at' => 'datetime',
        ];

   

}