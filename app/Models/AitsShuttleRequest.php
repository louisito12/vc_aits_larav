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

    }


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
}
