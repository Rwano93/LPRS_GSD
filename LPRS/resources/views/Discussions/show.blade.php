<!-- resources/views/discussions/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>{{ $discussion->title }}</h1>
    <p>{{ $discussion->content }}</p>
    <p>Posté par {{ $discussion->user->name }} dans la catégorie {{ $discussion->category->name }}</p>

    <hr>

    <h2>Réponses</h2>

    @foreach ($discussion->replies as $reply)
        <div>
            <p>{{ $reply->content }}</p>
            <p>Réponse de {{ $reply->user->name }}</p>
        </div>
        <hr>
    @endforeach

    <!-- Formulaire pour ajouter une réponse -->
    @auth
        <h3>Répondre à cette discussion</h3>
        <form action="{{ route('replies.store') }}" method="POST">
            @csrf
            <input type="hidden" name="discussion_id" value="{{ $discussion->id }}">
            <div class="form-group">
                <label for="content">Votre réponse</label>
                <textarea name="contenu" id="content" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Répondre</button>
        </form>
    @endauth
@endsection
