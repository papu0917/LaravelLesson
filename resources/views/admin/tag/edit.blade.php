@extends('layouts.admin')
@section('title', 'タグの編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>タグの編集</h2>
                <form action="{{ action('Admin\TagController@update') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2">タグ</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="{{ $tag_form->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10"></div>
                            <input type="hidden" name="id" value="{{ $tag_form->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
