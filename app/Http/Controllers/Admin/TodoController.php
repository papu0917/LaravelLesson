<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ToDo;
use App\Category;
use App\User;
use App\Favorite;
use App\Tag;
use Auth;
use Carbon\Carbon;

class TodoController extends Controller
{
    public function add()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.todo.create', ['categories' => $categories, 'tags' => $tags]);
    }
    
    public function create(Request $request)
    {
        // dd($request);
        $this->validate($request, ToDo::$rules);
        $todo = new ToDo;
        $form = $request->all();
        
        unset($form['_token']);
        
        $todo->fill($form);
        $todo->user_id = Auth::id();
        $todo->is_complete = 0;
        $todo->is_favorite = 0;
        $todo->save();

        // $todo->tags()->attach(); // id=1のTagを紐付ける
        // $todo_id->tags->save();
        
        return redirect('admin/todo/create');
    }
    // ログイン中のユーザーのtodoの一覧
    public function index(Request $request)
    {
        // $todo = ToDo::find(44);
        // dd($todo->tags);

        $user = Auth::user();
        $toDoQuery = ToDo::where('user_id', $user->id); //$userによる投稿を取得
        $toDoQuery->where('is_complete', 0);

        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            $toDoQuery->where('title', $cond_title);
        }
        
        $order = $request->order;
        if ($order != '') {
            $toDoQuery->orderBy('priority', $order);
        }
        
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $toDoQuery->whereHas('category', function($query) use ($cond_name) {
                $query->where('name', $cond_name);
            });
        }
        
        $toDos = $toDoQuery->paginate(5);
        
        // dd($toDos);
        
        
        return view('admin.todo.index', ['posts' => $toDos, 'cond_title' => $cond_title, 'cond_name' => $cond_name]);
    }
    
    public function edit(Request $request)
    {
        $todo = ToDo::find($request->id);
        if (empty($todo)) {
            abort(404);
        }
        
        $categories = Category::all();
        
        return view('admin.todo.edit', ['todo_form' => $todo, 'categories' => $categories]);
    }
    
    public function update(Request $request)
    {
        $this->validate($request, ToDo::$rules);
        $todo = ToDo::find($request->id);
        $todo_form = $request->all();
        unset($todo_form['_token']);
        
        $todo->fill($todo_form)->save();
        
        return redirect('admin/todo');
    }
    
    public function delete(Request $request)
    {
        $todo = ToDo::find($request->id);
        $todo->delete();
        
        return redirect('admin/todo/');
    }
    
    public function complete(Request $request)
    {
        $todo = ToDo::find($request->id);
        $todo->is_complete = 1;
        $todo->save();
        
        return redirect('admin/todo/completed');
    }
    
    public function completed(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            $posts = ToDo::where('title', $cond_title)->get();
        } else {
            $posts = ToDo::where('is_complete', 1)->get();
        }
        
        return view('admin.todo.completed', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    
    public function uncomplete(Request $request)
    {
        $todo = ToDo::find($request->id);
        $todo->is_complete = 0;
        $todo->save();
        
        return redirect('admin/todo/');
    }

    public function favorite(Request $request)
    {
        // $todo = ToDo::find($request->id);
        // $todo->is_favorite = 1;
        // $todo->save();
        
        // return redirect('admin/todo/favorites');
    }

    public function favorites(Request $request)
    {
        $user = Auth::user();
        $users = $user->todo_favorites;
        
        
        return view('admin.todo.favorites', ['users' => $users]);
    }


    public function unfavorites(Request $request)
    {
        $todo = ToDo::find($request->id);
        $todo->is_favorite = 0;
        $todo->save();
        
        return redirect('admin/todo/');
    }
}