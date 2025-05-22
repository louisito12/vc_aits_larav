<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AitsDelivery extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function get_area_request()
    {

        return $this->hasOne(AitsArea::class, 'id', 'area_id');

    }
    public function get_requestor()
    {
        return $this->hasOne(UserModel::class, 'id', 'user_id');

    }
    public function get_delivery_type(){

        return $this->hasOne(AitsDeliveryType::class, 'id', 'delivery_type_id');



    }
     public function get_requestor_fullname()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'user_id');

    }

}
