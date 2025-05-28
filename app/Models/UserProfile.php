<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $connection = 'main_user';
    protected $table = 'tbl_personal_datas';


    protected $guarded = [];

}
