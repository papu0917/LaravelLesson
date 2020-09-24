<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $guarded = array('id');
    protected $dates = ['dead_line_date'];
    protected $table = 'to_dos';

    public static $rules = array(
        'title' => 'required',
        
    );

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'todo_favorite');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'todo_tag');
    }
}
