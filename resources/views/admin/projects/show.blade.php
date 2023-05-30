@extends('layouts.app')


@section('content')

    <div class="container py-5">
        <h2>Titolo: {{$project->title}}</h2>
        <h2>Titolo 2: {{$project->slug}}</h2>
        <p>Tipologia: {{$project->type?$project->type->name:'Nessuna tipologia salvata'}}</p>

        <h4>Tecnologia:</h4>
        @foreach ($project->technologies as $technology)
        
            <p>{{$technology->name . ';'}}</p>

        @endforeach

        <div>
            @if ($project->cover_image)
            <img src="{{asset('storage/' . $project->cover_image)}}" alt="{{$project->title}}"/>
        @endif
        </div>

        <p>Descrizione: {{$project->content}}</p>
    </div>
@endsection