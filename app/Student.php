<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table="student";
    protected $fillable = [
        'name', 'email', 'phone','attachment','date','state_id'
    ];

    public function getState()
    {
        return $this->belongsTo(State::class);
    }

    public function getTechnology()
    {
        return $this->belongsToMany(Technology::class);
    }
}
