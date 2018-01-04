<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="#">{{ $reply->owner->name }}</a>
            il y a {{ $reply->created_at->diffForHumans() }}
            </h5>

            <div>
                
                <form method="POST" action="{{route('favorites.store', [$reply->id])}}">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ str_plural('Aime', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <article>
            {{ $reply->body }}
        </article>
    </div>
</div>