<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = array('id');
    protected $table = 'todo_favorite';

    public static $rules = array(
        'to_do_id' => 'required',
        'user_id' => 'required',
    );   
}
