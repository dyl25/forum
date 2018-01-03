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
                        <header class="level">
                            <h4 class="flex">
                                <a href="{{ route('threads.show', ['slug' => $thread->channel->slug ,'id' => $thread->id]) }}">
                                    {{ $thread->title }}
                                </a>
                            </h4>
                            <a href="{{ route('threads.show', ['slug' => $thread->channel->slug ,'id' => $thread->id]) }}">
                                {{ $thread->replies_count }} {{str_plural('commentaire', $thread->replies_count)}}
                            </a>
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
