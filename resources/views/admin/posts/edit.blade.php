@extends( 'layouts.app' );

@section('content')
<div class="container">
    <h1>Form modifica progetto</h1>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li> {{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route( 'admin.posts.update', $post ) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{$post->title}}">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{$post->description}}</textarea>
        </div>
        
        <div class="form-group mt-3">
            <label for="input-image" class="form-label">Image</label>
            <input type="file" id="input-image" name="image" class="form-control">
        </div>

        <div class="form-group">
            <label for="type" class="form-label">Types</label>
            <select class="form-select" name="type_id" id="type">
                <option value="">- - Scegli Un Type - - </option>
                @foreach ($types as $elem)
                    <option value="{{$elem->id}}" {{old('type_id', $post->type_id) == $elem->id ? 'selected' : ''}}>{{$elem->name}}</option>
                @endforeach
            </select>
        </div>

        

        <div class="form-group mt-3">
            @foreach($technologies as $elem)
              <div class="form-check">
                @if($errors->any())
                    <input class="form-check-input" type="checkbox" value="{{$elem->id}}" id="checkbox{{$elem->id}}" name="technologies[]" {{in_array($elem->id, old('technologies', [])) ? 'checked' : ''}}>
                    
                @else
                    <input class="form-check-input" type="checkbox" value="{{$elem->id}}" id="checkbox{{$elem->id}}" name="technologies[]" {{($post->technologies->contains($elem))? 'checked' : ''}}>
                    
                @endif
                <label class="form-check-label" for="checkbox{{$elem->id}}">
                     {{$elem->name}}
                </label>
              </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-2">Inserisci modifiche</button>

    </form>
</div>
@endsection