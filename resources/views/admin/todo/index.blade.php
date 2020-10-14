@extends('layouts.admin')
@section('title', '登録済ToDoの一覧')

@section('content')
    <div class="container">
        <div class="row">
            </h2>ToDo一覧</h2>
        </div>
        <form action="{{ action('Admin\TodoController@index') }}" method="get">
            <select name="order">
                <option>並び替える</option>
                <option value="desc">優先度が高い順</option>
                <option value="asc">優先度が低い順</option>
            </select>
            <input type="submit" class="btn btn-primary" value="実行">
        </form>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\TodoController@create') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\TodoController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                        <label class="col-md-2">カテゴリー</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="15%">タイトル</th>
                                <th width="15%">期限日</th>
                                <th width="20%">優先度</th>
                                <th width="20%">カテゴリー</th>
                                <th width="10%">タグ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $todo)
                                @if (now() > $todo->deadline_date)
                                    <tr class="bg-warning">
                                    @else
                                    </tr>
                                @endif
                                <th>{{ $todo->id }}</th>
                                <td>{{ \Str::limit($todo->title, 100) }}</td>
                                <td>{{ $todo->deadline_date }}</td>
                                <th>{{ $todo->priority }}</th>
                                <td>{{ $todo->category->name }}</td>
                                <td>
                                    @foreach ($todo->tags as $tag) {{ $tag->name }}
                                    @endforeach
                                </td>
                                <td>
                                    <div>
                                        <a href="{{ action('Admin\TodoController@edit', ['id' => $todo->id]) }}">編集</a>
                                    </div>
                                    <div>
                                        <a href="{{ action('Admin\TodoController@delete', ['id' => $todo->id]) }}">削除</a>
                                    </div>
                                    <div>
                                        <a href="{{ action('Admin\TodoController@complete', ['id' => $todo->id]) }}">完了</a>
                                    </div>
                                    <div>
                                        <a
                                            href="{{ action('Admin\TodoController@favorites', ['id' => $todo->id]) }}">お気に入り</a>
                                    </div>
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $posts->links() }}
    </div>
@endsection
