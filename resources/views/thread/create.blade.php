@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Créer un sujet</div>

                <div class="panel-body">
                    <form method="POST" action="{{route('threads.store')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="channel_id">Choisir une section</label>
                            <select id="channel_id" name="channel_id" class="form-control" required>
                                <option value="">Choisir ...</option>
                                @foreach($channels as $channel)
                                <option value="{{$channel->id}}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{$channel->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input required type="text" class="form-control" id="title" name="title" placeholder="Titre" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="body">Contenu</label>
                            <textarea required name="body" id="body" class="form-control" rows="8">{{ old('body') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publier</button>
                        </div>

                        @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                        @endif

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
