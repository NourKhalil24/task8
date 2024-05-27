<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'first_name',
        'last_name',
        'email',
        'department_id',
        'position'
    ];

    public function departments(){
        return $this->belongsTo(Department::class);
    }

    public function projects (){
        return $this->belongsToMany(Project::class);
    }
    public function notes() {
        return $this->morphMany(Note::class,'noteable');
    }
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst(strtolower($value));
    }

    public function setLastNameAttribute($value){
        $this->attributes['last_name'] = ucfirst(strtolower($value));
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst(strtolower($value));
    }

    public function getLastNameAttribute($value) {
        return ucfirst(strtolower($value));
    }
}
