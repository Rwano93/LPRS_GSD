
<!-- resources/views/discussions/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Discussions</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('discussions.create') }}" class="btn btn-primary">Créer une nouvelle discussion</a>

        <div class="mt-4">
            @foreach($discussions as $discussion)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>{{ $discussion->title }}</h5>
                        <small>Par {{ $discussion->user->name }} dans {{ $discussion->category->name }}</small>
                    </div>
                    <div class="card-body">
                        <p>{{ $discussion->contenu }}</p>
                        <a href="{{ route('discussions.show', $discussion->id) }}" class="btn btn-link">Voir les détails</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
