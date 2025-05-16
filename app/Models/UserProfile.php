<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $connection = 'ict_ticketing';
    protected $table = 'tbl_personal_data';


    protected $guarded = [];

}
