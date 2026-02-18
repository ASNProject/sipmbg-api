<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'school_name',
        'school_address',
        'school_phone',
        'school_capacity',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'school_id');
    }
}
