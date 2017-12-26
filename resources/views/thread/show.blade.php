@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="#">{{ $thread->creator->name }}</a> a posté:
                    {{ $thread->title }}
                </div>

                <div class="panel-body">
                    <article>
                        {{ $thread->body }}
                    </article>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($thread->replies as $reply)
                @include('thread.reply')
            @endforeach
        </div>
    </div>
    @if (auth()->check())
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form method="POST" action="{{ route('replies.store', ['slug' => $thread->channel->slug,'id' => $thread->id]) }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body" 
                              class="form-control" 
                              placeholder="Poster un commentaire?" 
                              rows="5"></textarea>
                </div>
                
                <button type="submit" class="btn btn-default">Poster</button>
            </form>
        </div>
    </div>
    @else
    <p class="text-center">Veuillez vous <a href="{{route('login')}}">connecter</a> pour participer à la conversation.</p>
    @endif
</div>
@endsection
