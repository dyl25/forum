@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Forum Threads</div>

                <div class="panel-body">
                    @foreach($threads as $thread)
                    <article>
                        <header>
                            <h4>
                                <a href="{{ action('ThreadController@show', ['id' => $thread->id]) }}">{{ $thread->title }}</a>
                            </h4>
                        </header>
                        <div class="body">{{ $thread->body }}</div>
                    </article>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
