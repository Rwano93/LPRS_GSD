<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($offer) ? __('Modifier l\'offre') : __('Créer une offre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ isset($offer) ? route('offers.update', $offer) : route('offers.store') }}" method="POST">
                    @csrf
                    @if(isset($offer))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre:</label>
                        <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $offer->title ?? old('title') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type:</label>
                        <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="alternance" {{ (isset($offer) && $offer->type == 'alternance') ? 'selected' : '' }}>Alternance</option>
                            <option value="stage" {{ (isset($offer) && $offer->type == 'stage') ? 'selected' : '' }}>Stage</option>
                            <option value="CDD" {{ (isset($offer) && $offer->type == 'CDD') ? 'selected' : '' }}>CDD</option>
                            <option value="CDI" {{ (isset($offer) && $offer->type == 'CDI') ? 'selected' : '' }}>CDI</option>
                            <option value="Intérim" {{ (isset($offer) && $offer->type == 'Intérim') ? 'selected' : '' }}>Intérim</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                        <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $offer->description ?? old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Date de début:</label>
                        <input type="date" name="start_date" id="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $offer->start_date ?? old('start_date') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Date de fin (optionnel):</label>
                        <input type="date" name="end_date" id="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $offer->end_date ?? old('end_date') }}">
                    </div>

                    <div class="mb-4">
                        <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Lieu:</label>
                        <input type="text" name="location" id="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $offer->location ?? old('location') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="salary" class="block text-gray-700 text-sm font-bold mb-2">Salaire (optionnel):</label>
                        <input type="number" step="0.01" name="salary" id="salary" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $offer->salary ?? old('salary') }}">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ isset($offer) ? 'Mettre à jour' : 'Créer' }}
                        </button>
                        <a href="{{ route('offers.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>