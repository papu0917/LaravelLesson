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

// クラス
class TodoController extends Controller
{
    // メソッド
    public function add()
    {
        // インスタンス
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.todo.create', ['categories' => $categories, 'tags' => $tags]);
    }

    public function create(Request $request)
    {
        // dd($request); // リクエストのTag_idがいつの間にかnullになっている　訳わからん
        $this->validate($request, ToDo::$rules);
        $todo = new ToDo;
        // $todo = ToDo::whereHas('tag_id', $tag->id);
        // $tag = new Tag;
        $form = $request->all();

        unset($form['_token']);

        $todo->fill($form);
        $todo->user_id = Auth::id();
        $todo->is_complete = 0;
        $todo->is_favorite = 0;
        $todo->save();
        $todo->tags()->attach($request->tag_ids);

        return redirect('admin/todo/');
    }
    // ログイン中のユーザーのtodoの一覧
    public function index(Request $request)
    {

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
            $toDoQuery->whereHas('category', function ($query) use ($cond_name) {
                $query->where('name', $cond_name);
            });
        }

        $toDos = $toDoQuery->paginate(5);

        return view('admin.todo.index', ['posts' => $toDos, 'cond_title' => $cond_title, 'cond_name' => $cond_name]);
    }

    public function edit(Request $request)
    {
        $todo = ToDo::find($request->id);
        if (empty($todo)) {
            abort(404);
        }

        $tags = Tag::all();
        $categories = Category::all();

        return view('admin.todo.edit', ['todo_form' => $todo, 'categories' => $categories, 'tags' => $tags]);
    }

    public function update(Request $request)
    {
        $this->validate($request, ToDo::$rules);
        $todo = ToDo::find($request->id);
        $todo_form = $request->all();
        unset($todo_form['_token']);

        $todo->fill($todo_form)->save();
        $todo->tags()->sync($request->tags);

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
        // $favorites = ToDo::all();
        // $favorites = ToDo::where('user_id', $user->id);
        // $favorites->where('is_complete', 0);
        $favorites = $user->todo_favorites;
        // $favorites->users()->attach($todo_favorites);
        // $favorites->save();

        // $cond_title = $request->cond_title;
        // if ($cond_title != '') {
        //     $favorites->where('title', $cond_title);
        // }

        // $favorites->get();
        // 'cond_title' => $cond_title
        return view('admin.todo.favorites', ['favorites' => $favorites]);
    }


    public function unfavorites(Request $request)
    {
        $todo = ToDo::find($request->id);
        $todo->is_favorite = 0;
        $todo->save();

        return redirect('admin/todo/');
    }

    public function test()
    {
        return view('admin.todo.test');
    }
}
