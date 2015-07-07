<?php namespace Jql;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public static $rules = [
        'name'    => 'required',
        'priority'   => 'required',//|unique:projects',
    ];
    protected $fillable = ['name', 'priority'];
    
    // public function user()
    // {
    //     return $this->belongsTo('User');
    // }
    // public function tasks()
    // {
    //     return $this->hasMany('Task');
    // }
}
