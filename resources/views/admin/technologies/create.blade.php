@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <form method="POST" action="{{route('admin.technologies.store')}}">

            @csrf
    
            <div class="mb-3">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" id="name" name="name">

                @error('name')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            
    
            <button type="submit" class="btn btn-primary">Aggiungi</button>
        </form>
    </div>
@endsection