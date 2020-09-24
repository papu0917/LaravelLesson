@extends('layouts.admin')
@section('title', 'ToDoの新規作成')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>ToDo新規作成</h2>
                <form action="{{ action('Admin\TodoController@create') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">期限日</label>
                        <div class="col-md-10">
                            <input type="date" class="form-control" name="deadline_date" value="{{ old('deadline_date') }}">
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
                                <option value="{{ old('priority') }}">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">カテゴリー</label>
                        <div class="col-md-10">
                            <select name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">タグ</label>
                        <div class="col-md-10">
                                @foreach($tags as $tag)
                                    <input type="checkbox" name="tag_id[]" value="{{ old('tag->id') }}">{{ $tag->name }}
                                @endforeach
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
            </div>
        </div>
    </div>
@endsection