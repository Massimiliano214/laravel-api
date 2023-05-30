@extends('layouts.app')

@section('content')

    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Nome</th>
            <th scope="col">Numero di Progetti</th>
            <th scope="col">Azioni</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($technologies as $technology)
                <tr>
                    <td>{{$technology->id}}</td>
                    <td>{{$technology->name}}</td>
                    <td>{{count($technology->projects)}}</td>
                    <td class="d-flex">
                        <a class="btn btn-primary me-3" href="{{route('admin.technologies.show', ['technology' => $technology->slug])}}">Dettagli</a>
                        <a class="btn btn-secondary me-3" href="{{route('admin.technologies.edit', ['technology' => $technology->slug])}}">Modifica</a>
                        <form action="{{route('admin.technologies.destroy', ['technology' => $technology->slug])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger delete">Elimina</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>      
    </table>
    <a href="{{route('admin.technologies.create')}}" class="btn btn-secondary">Aggiungi Tipologia</a>
@endsection