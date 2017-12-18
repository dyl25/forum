<div class="panel panel-default">
    <div class="panel-heading">
        <a href="#">{{ $reply->owner->name }}</a>
        il y a {{ $reply->created_at->diffForHumans() }}
    </div>
    <div class="panel-body">
        <article>
            {{ $reply->body }}
        </article>
    </div>
</div>