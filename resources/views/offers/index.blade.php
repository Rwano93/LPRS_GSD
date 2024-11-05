<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Offres') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Liste des offres</h3>
                
                @if(isset($offers) && $offers->count() > 0)
                    <ul>
                        @foreach($offers as $offer)
                            <li class="mb-2">{{ $offer->title }} - {{ $offer->type }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucune offre disponible pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>