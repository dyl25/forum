@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <span class="flex">
                            <a href="{{ route('profiles.show', [$thread->creator]) }}">{{ $thread->creator->name }}</a> a posté:
                            {{ $thread->title }}
                        </span>
                        @can('update', $thread)
                        <form action="{{ 
                            route('threads.delete', [$thread->channel->slug, $thread->id]) 
                              }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link">Supprimer le sujet</button>
                        </form>
                        @endcan
                    </div>
                </div>

                <div class="panel-body">
                    <article>
                        {{ $thread->body }}
                    </article>
                </div>
            </div>
            @foreach($replies as $reply)
            @include('thread.reply')
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
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
            @else
            <p class="text-center">Veuillez vous <a href="{{route('login')}}">connecter</a> pour participer à la conversation.</p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        Ce sujet à été publié {{ $thread->created_at->diffForHumans() }} par 
                        <a href="#">{{ $thread->creator->name }}</a>, et possède 
                        {{ $thread->replies_count }} {{ str_plural('commentaire', $thread->replies_count) }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
