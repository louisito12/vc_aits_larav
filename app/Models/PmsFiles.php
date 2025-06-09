<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmsFiles extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function get_pms_details()
    {

        return $this->hasOne(Pms_Details::class, 'id', 'pms_id');

    }
}
