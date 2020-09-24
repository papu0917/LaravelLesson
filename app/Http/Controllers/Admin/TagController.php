<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function add(Request $request)
    {
        return view('admin.tag.create');
    }

    public function create(Request $request)
    {
        $tag = new Tag;
        $form = $request->all();
        unset($form['_token']);
        
        $tag->fill($form);
        $tag->save();
        
        return redirect('admin/tag');
    }

    public function index(Request $request)
    {
        
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $tag = Tag::where('name', $cond_name)->get();;
        } else {
            $tag = Tag::all();
        }
        $posts = Tag::paginate(5);
        
        return view('admin.tag.index', ['posts' => $posts, 'tag' => $tag, 'cond_name' => $cond_name]);
    }

    public function edit(Request $request)
    {
        $tag = Tag::find($request->id);
        if (empty($tag)) {
            abort(404);
        }
        
        return view('admin.tag.edit', ['tag_form' => $tag]);

    }

    public function update(Request $request)
    {
        $tag = Tag::find($request->id);
        $tag_form = $request->all();
        unset($tag_form['_token']);
        
        $tag->fill($tag_form)->save();
        
        return redirect('admin/tag/');
    }

    public function delete(Request $request)
    {
        $tag = Tag::find($request->id);
        $tag->delete();
        
        return redirect('admin/tag/');
    }
}
