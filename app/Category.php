<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="category";
    protected $fillable = [
        'name','hr_id'
    ];
    // Get The User Name

    public function getUserName()
    {
        return $this->belongsTo(User::class,"hr_id");
    }

    public function getcreatedatAttribute($value)
    {
        $date=date_create($value);
        return date_format($date,"d M Y");
    }
}
