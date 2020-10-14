@extends('layouts.admin')
@section('title', 'ToDoの編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>ToDoの編集</h2>
                <form action="{{ action('Admin\TodoController@update') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ $todo->title }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">期限日</label>
                        <div class="col-md-10">
                            <input type="date" class="form-control" name="deadline_date" value="{{ $todo->deadline_date }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">優先度</label>
                        <div class="col-md-10">
                            <select name="priority">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option value="{{ $todo->priority }}">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">カテゴリー</label>
                        <div class="col-md-10">
                            <select name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">タグ</label>
                        <div class="col-md-10">
                            @foreach ($tags as $tag)
                                <div class="form-check">
                                    @if ($todo->tags->search(function ($item, $key) use ($tag) {
            return $item->id == $tag->id;
        }) !== false)
                                        <input type="checkbox" name="tags[]" id="tag{{ $loop->iteration }}"
                                            value="{{ $tag->id }}" checked />
                                    @else
                                        <input type="checkbox" name="tags[]" id="tag{{ $loop->iteration }}"
                                            value="{{ $tag->id }}" />
                                    @endif
                                    <label for="tag{{ $loop->iteration }}">{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="id" value="{{ $todo->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                            <a href="{{ action('Admin\TodoController@index') }}" role="button"
                                class="btn btn-primary">戻る</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
