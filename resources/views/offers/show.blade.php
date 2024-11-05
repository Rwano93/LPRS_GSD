<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de l\'offre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">{{ $offer->title }}</h3>
                <p><strong>Type:</strong> {{ $offer->type }}</p>
                <p><strong>Description:</strong> {{ $offer->description }}</p>
                <p><strong>Date de début:</strong> {{ $offer->start_date }}</p>
                @if($offer->end_date)
                    <p><strong>Date de fin:</strong> {{ $offer->end_date }}</p>
                @endif
                <p><strong>Lieu:</strong> {{ $offer->location }}</p>
                @if($offer->salary)
                    <p><strong>Salaire:</strong> {{ $offer->salary }} €</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('offers.edit', $offer) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Modifier</a>
                    <form action="{{ route('offers.destroy', $offer) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700  text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">Supprimer</button>
                    </form>
                    <a href="{{ route('offers.index') }}" class="ml-2 inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Retour à la liste</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>