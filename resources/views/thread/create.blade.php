@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Créer un sujet</div>

                <div class="panel-body">
                    <form method="POST" action="{{action('ThreadController@store')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Titre">
                        </div>
                        <div class="form-group">
                            <label for="body">Contenu</label>
                            <textarea name="body" id="body" class="form-control" rows="8"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
