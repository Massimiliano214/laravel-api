@extends('layouts.app')

@section('content')

<table class="table">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">Immagine</th>
        <th scope="col">Titolo</th>
        <th scope="col">Slug</th>
        <th scope="col">Tipologia</th>
        <th scope="col">Tecnologia</th>
        <th scope="col">Azioni</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($projects as $project)
            <tr>
                <td>{{$project->id}}</td>
                <td>
                  @if ($project->cover_image)
                      <img class="myThumb" src="{{asset('storage/' . $project->cover_image)}}" alt="{{$project->title}}"/>
                  @endif
              </td>
                <td>{{$project->title}}</td>
                <td>{{$project->slug}}</td>
                <td>{{$project->type?->name}}</td>
                <td>

                  @foreach ($project->technologies as $technology)
          
                    <span>{{$technology->name . ';'}}</span>
  
                  @endforeach

                </td>
                <td class="d-flex">
                  <a class="btn btn-primary me-3" href="{{route('admin.projects.show', ['project' => $project->slug])}}">Dettagli</a>
                  <a class="btn btn-secondary me-3" href="{{route('admin.projects.edit', ['project' => $project->slug])}}">Modifica</a>
                  <form class="form_delete_post" action="{{route('admin.projects.destroy', ['project' => $project->slug])}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <!--onclick="return confirm('Are you sure?')"-->
                      <button type="submit" class="btn btn-danger delete">Elimina</button>
                  </form>
              </td>
            </tr>
            @endforeach
          </tbody>      
  </table>
  <a href="{{route('admin.projects.create')}}" class="btn btn-secondary">Aggiungi Progetto</a>

  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma eliminazione</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Confermi di voler eliminare l'elemento selezionato?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger">Conferma eliminazione</button>
        </div>
      </div>
    </div>
  </div>
@endsection
