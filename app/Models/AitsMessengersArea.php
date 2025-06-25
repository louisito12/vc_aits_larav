<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AitsMessengersArea extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function get_user_data()
    {
        return $this->belongsTo(UserModel::class, 'messenger_id', 'id');
    }

    public function get_user_profile()
    {
        return $this->belongsTo(UserProfile::class, 'messenger_id', 'user_id');
    }

    public function get_area()
    {
        return $this->belongsTo(AitsArea::class, 'area_id', 'id');
    }



    //54

}
