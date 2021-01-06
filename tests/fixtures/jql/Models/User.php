<?php namespace Jql\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public static $rules = [
        'username'  => 'required',
        'email'     => 'required|email',
        'password'  => 'required',
    ];
}
