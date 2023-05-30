@extends('layouts.app')

@section('title', 'Modifica Type')

@section('content')

    <div class="container py-5">

        <form method="POST" action="{{route('admin.types.update', ['type' => $type->id])}}">
           
            @csrf

            @method('PUT')
    
            <div class="mb-3">
                <label for="name" class="form-label">Nome Tipologia:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $type->name)}}">

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>    
            <button type="submit" class="btn btn-primary">Aggiorna</button>
        </form>
    </div>
@endsection