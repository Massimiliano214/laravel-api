@extends('layouts.app')

@section('content')

    <div class="container py-5">

        <form method="POST" action="{{route('admin.projects.store')}}" enctype="multipart/form-data">

            @csrf
    
            <div class="mb-3">
                <label for="title" class="form-label">Titolo:</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}" id="title" name="title">

                @error('title')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type_id" class="form-label">Selettore tipologia:</label>
                <select class="form-select" @error('type_id') is-invalid @enderror name="type_id" id="type_id">
                    <option @selected(old('type_id')=='') value="">Nessuna tipologia</option>
                    @foreach ($types as $type)
                        <option @selected(old('type_id')==$type->id) value="{{$type->id}}">{{$type->name}}</option>    
                    @endforeach
                </select>

                @error('type_id')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                @foreach ($technologies as $technology)
                
                    <input id="technology_{{$technology->id}}" @if (in_array($technology->id, old('technologies', []))) checked @endif type="checkbox" name="technologies[]" value="{{$technology->id}}">
                    <label for="technology_{{$technology->id}}" class="form-label">{{$technology->name}}</label><br>
                
                @endforeach

                @error('technologies')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">

                <label for="cover_image" class="form-label">Scegli immagine:</label>
                <input type="file" class="form-control @error('cover_image') is-invalid @enderror " id="cover_image" name="cover_image">

                @error('cover_image')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Contenuto:</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content">{{old('content')}}</textarea>
                
                @error('content')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
    
            <button type="submit" class="btn btn-primary">Aggiungi</button>
        </form>
    </div>
@endsection