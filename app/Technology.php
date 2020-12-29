<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $table="technology";
    protected $fillable = [
        'tech' ];
    public function getUser()
    {
        return $this->belongsToMany(Student::class);
    }
}
