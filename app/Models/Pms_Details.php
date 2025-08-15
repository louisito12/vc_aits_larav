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


    public function get_noted_by()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'noted_by');
    }
}
