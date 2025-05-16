<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserModel extends Authenticatable
{
    use HasFactory;
    protected $connection = 'ict_ticketing';
    protected $table = 'users';


    protected $guarded = [];

    public function get_user_data()
    {

        return $this->hasOne(UserProfile::class, 'user_id', 'id');

    }


}
