@foreach ($evenements as $evenement)
    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-500 hover:scale-105">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-2 text-gray-800">{{ $evenement->titre }}</h3>
            <p class="text-gray-600 mb-2">Type: {{ $evenement->type }}</p>
            <p class="text-gray-600 mb-4">{{ Str::limit($evenement->description, 100) }}</p>
            <div class="text-sm text-gray-500 mb-2">Adresse: {{ $evenement->adresse }}</div>
            <div class="text-sm text-gray-500 mb-2">Éléments requis: {{ $evenement->elements_requis }}</div>
            <div class="flex justify-between items-center text-sm text-gray-500">
                <span>Date: {{ $evenement->date }}</span>
                <span>Places: {{ $evenement->nb_place }}</span>
            </div>
        </div>
        <div class="bg-gray-100 px-6 py-4 flex justify-end space-x-2">
            <button @click="openEditModal({{ $evenement->toJson() }})" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </button>
            <button @click="confirmDelete({{ $evenement->id }})" class="text-red-500 hover:text-red-700 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </div>
    </div>
@endforeach

<div id="pagination-info" class="hidden">
    {{ json_encode($evenements->toArray()) }}
</div>