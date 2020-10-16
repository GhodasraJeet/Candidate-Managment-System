<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $table="interview";
    protected $fillable = [
        'name','email','phone','other_phone','category_id','experience','current_salary','expected_salary','graduation','practical_remarks','technical_remarks','general_remarks','hr_id'
    ];

    // Get Category Details
    public function getCategory()
    {
        return $this->belongsTo(Category::class,"category_id");
    }

    // Get HR Details
    public function getHrDetails()
    {
        return $this->belongsTo(User::class,'hr_id')->withTrashed();
    }

    public function getcreatedatAttribute($value)
    {
        $date=date_create($value);
        return date_format($date,"d M Y");
    }
}
