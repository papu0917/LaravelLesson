@extends('layouts.admin')
@section('title', 'お気に入りの一覧')

@section('content')
    <div class="container">
        <div class="row">
            </h2>お気に入りToDo一覧</h2>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ユーザー名</th>
                                <th width="10%">ユーザーID</th>
                                <th width="20%">お気に入りタイトル</th>
                            </tr>
                        </thead>
                        <tbody>                  
                            @foreach($favorites as $favorites)
                                <tr>
                                    <th>{{ auth()->user()->name }}</th>
                                    <th>{{ auth()->user()->id }}</th>
                                    <th>{{ $favorites->title }}</th>
                                    <td>
                                        <div>
                                            <a href="{{ action('Admin\TodoController@unfavorites', ['id' => $favorites]) }}">お気に入りから外す</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

