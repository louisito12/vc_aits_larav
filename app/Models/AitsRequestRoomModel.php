<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AitsRequestRoomModel extends Model
{
    use HasFactory;


    public function get_event_data()
    {
        return $this->hasOne(AitsEventModel::class, 'id', 'event_id');
    }

    public function get_room_data()
    {
        return $this->hasOne(AitsRoomModel::class, 'id', 'room_id');

    }

    public function get_requestor()
    {
        return $this->hasOne(UserModel::class, 'id', 'request_by');

    }


    public function get_requestor_data()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'request_by');
    }
    // public function get_department()
    // {
    //     return $this->hasOneThrough(
    //         DepartmentModel::class,
    //         UserProfile::class,
    //         'user_id', // Foreign key on the UserProfile table
    //         'id',      // Foreign key on the DepartmentModel table
    //         'request_by', // Local key on the current model
    //         'department_id'     // Local key on the UserProfile table
    //     );
    // }
    public function get_department()
    {
        return $this->belongsTo(DepartmentModel::class, 'department_id');
    }


    public function get_approved_data()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'approve_by');
    }

}
