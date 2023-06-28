@extends('layouts.app')

@section('content')
<h1 class="text-center p-4">Singolo Post</h1>
<div class="card mx-auto" style="width: 18rem;">
    <div class="card-body">
        <img src="{{asset('storage/' . $singoloPost->image)}}" class="card-img-top" alt="foto">
        <h5 class="card-title">{{ $singoloPost->title }}</h5>
        <p class="card-text">{{$singoloPost->description}}</p>
        @if ($singoloPost->type)
        <div class="text-warning">Tipologia:</div>
        <div>
            <p>{{$singoloPost->type->name}}</p>
        </div>
        @endif

        @if( $singoloPost->technologies )
        <div class="text-warning">Utilizzo di:</div>
        @foreach ( $singoloPost->technologies as $elem )
        <div>{{ $elem->name }} </div>
        @endforeach
        @endif

        <a href="{{route('admin.posts.edit', $singoloPost)}}" class="btn btn-primary">Modifica</a>


    </div>
</div>




@endsection
