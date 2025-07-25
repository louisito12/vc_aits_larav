<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AitsShuttleRequest extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function get_event_data()
    {
        return $this->belongsTo(AitsShuttleType::class, 'type', 'id');
        // return $this->belongsTo(AitsShuttleType::class, 'type', 'id')->withDefault();

    }
    // public function getTestDataAttribute()
    // {
    //     return $this->get_event_data->test_data();
    // }


    public function get_requestor()
    {
        return $this->hasOne(UserModel::class, 'id', 'user_id');

    }


    public function get_requestor_data()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'user_id');
    }

    public function get_approver_data()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'approved_by');
    }

    public function get_manager_data()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'manager_id');

    }


    public function get_driver_data()
    {
        return $this->hasOne(AitsDriver::class, 'cen_user_id', 'driver_id');

    }

    public function get_car_data()
    {
        return $this->hasOne(AitsVehicleModel::class, 'id', 'car_id');

    }


    public function get_app_remarks()
    {
        return $this->hasOne(AitsProcessRemarks::class, 'attachment_id', 'id')->where('procedures', 'Approve- Shuttle Request')->where('table_name', 'aits_shuttle_requests');

    }

}
