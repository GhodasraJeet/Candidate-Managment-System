<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="category";
    protected $fillable = [
        'name','hr_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Get The HR Details

    public function getUserName()
    {
        return $this->belongsTo(User::class,"hr_id");
    }
    // Get The proper date

    public function getcreatedAtAttribute($value)
    {
        $date=date_create($value);
        return date_format($date,"d M Y");
    }
}
