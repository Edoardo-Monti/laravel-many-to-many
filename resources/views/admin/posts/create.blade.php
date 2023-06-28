@extends('layouts.app')

@section('content')

<h1 class="text-center">Crea Un Nuovo Post</h1>
<div class="container">
    <form action="{{ route( 'admin.posts.store' ) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror">
            @error('title')
                <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="50" rows="10"></textarea>
            @error('description')
                <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="slug" class="form-label">slug</label>
            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror">
            @error('slug')
                <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="input-image" class="form-label">Image</label>
            <input type="file" id="input-image" name="image" class="form-control">
        </div>

        <div class="form-group mt-3">
            @foreach($technologies as $elem)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{$elem->id}}" id="checkbox{{$elem->id}}" name="technologies[]">
                <label class="form-check-label" for="checkbox{{$elem->id}}">
                     {{$elem->name}}
                </label>
              </div>
            @endforeach
        </div>

        
    
        <button type="submit" class="btn btn-primary">Crea Fumetto</button>
</div>


@endsection
