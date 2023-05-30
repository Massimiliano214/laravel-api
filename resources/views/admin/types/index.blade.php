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
            @foreach ($types as $type)
                <tr>
                    <td>{{$type->id}}</td>
                    <td>{{$type->name}}</td>
                    <td>{{count($type->projects)}}</td>
                    <td class="d-flex">
                        <a class="btn btn-primary me-3" href="{{route('admin.types.show', ['type' => $type->id])}}">Dettagli</a>
                        <a class="btn btn-secondary me-3" href="{{route('admin.types.edit', ['type' => $type->id])}}">Modifica</a>
                        <form action="{{route('admin.types.destroy', ['type' => $type->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger delete">Elimina</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>      
    </table>
    <a href="{{route('admin.types.create')}}" class="btn btn-secondary">Aggiungi Tipologia</a>
@endsection