@extends('layouts.app')


@section('content')

    <div class="container py-5">
        <h1>Tecnologia progetto:</h1>
        <h2>{{$technology->name}}</h2>
        <span>slug: {{$technology->slug}}</span>
    </div>
@endsection