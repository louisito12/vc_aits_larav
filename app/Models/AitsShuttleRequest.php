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
}
