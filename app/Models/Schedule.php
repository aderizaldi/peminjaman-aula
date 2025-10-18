<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function times()
    {
        return $this->hasMany(Time::class);
    }

    public function approved_rejected_user()
    {
        return $this->belongsTo(User::class, 'approved_rejected_by');
    }
}
