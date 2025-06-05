<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pms_Details extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'pms_details';


    protected $guarded = [];
}
