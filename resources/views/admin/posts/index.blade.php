@extends('layouts.app')

@section('content')
<h1 class="text-center p-4">I Miei Post</h1>
<div class="container">
    <div class="row mx-auto g-4">
        @foreach ($posts as $elem)
        <a href="{{ route('admin.posts.show',$elem)}}">
            <div class="card mx-auto" style="width: 18rem;">
                <img src="{{asset('storage/' . $elem->image)}}" class="card-img-top" alt="foto">
                <div class="card-body">
                    <h5 class="card-title">{{$elem->title}}</h5>
                    <p class="card-text">{{$elem->description}}</p>
                    <form action="{{route('admin.posts.destroy', $elem)}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-delete">Elimina</button>
                    </form>
                </div>
            </div>
        </a>
        
        @endforeach
    </div>
</div>

@endsection
