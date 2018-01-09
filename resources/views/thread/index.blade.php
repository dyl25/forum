@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @forelse($threads as $thread)
            <article class="panel panel-default">
                <div class="panel-heading">
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
                </div>
                <div class="panel-body">
                        <div class="body">{{ $thread->body }}</div>
                    <hr>
                </div>
            </article>
            @empty
                <p>Pas encore de sujets pour cette section</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
