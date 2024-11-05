<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Événements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div x-data="evenements()" x-init="init()" class="space-y-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <div class="w-full sm:w-1/2 mb-4 sm:mb-0">
                            <div class="relative">
                                <input 
                                    x-model="search" 
                                    @input.debounce.300ms="fetchEvenements()"
                                    type="text" 
                                    placeholder="Rechercher un événement..." 
                                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out"
                                >
                                <div class="absolute left-3 top-2">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>
                        </div>
                        <button 
                            @click="openCreateModal()" 
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                        >
                            Créer un événement
                        </button>
                    </div>

                    <div id="evenements-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($evenements as $evenement)
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
                                    <a href="{{ route('evenements.show', $evenement) }}" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <button @click="openEditModal({{ $evenement->toJson() }})" class="text-green-500 hover:text-green-700 focus:outline-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button @click="confirmDelete({{ $evenement->id }})" class="text-red-500 hover:text-red-700 focus:outline-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div x-show="loading" class="flex justify-center">
                        <svg class="animate-spin h-10 w-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    <div x-show="!loading && totalPages > 1" class="flex justify-center space-x-2">
                        <template x-for="page in totalPages" :key="page">
                            <button 
                                @click="changePage(page)" 
                                :class="{'bg-blue-500 text-white': currentPage === page, 'bg-gray-200 text-gray-700': currentPage !== page}"
                                class="px-4 py-2 rounded-lg transition duration-150 ease-in-out"
                                x-text="page"
                            ></button>
                        </template>
                    </div>
                </div>

                <!-- Modal de création/édition -->
                <div x-show="showCreateModal || showEditModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <!-- ... (le contenu du modal reste inchangé) ... -->
                </div>

                <!-- Modal de confirmation de suppression -->
                <div x-show="showDeleteModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <!-- ... (le contenu du modal reste inchangé) ... -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script>
        function evenements() {
            return {
                evenements: [],
                search: '',
                loading: false,
                currentPage: 1,
                totalPages: 1,
                showCreateModal: false,
                showEditModal: false,
                showDeleteModal: false,
                formData: {
                    id: null,
                    type: '',
                    titre: '',
                    description: '',
                    adresse: '',
                    elements_requis: '',
                    nb_place: '',
                    date: ''
                },
                errors: {},
                eventToDelete: null,

                init() {
                    this.fetchEvenements();
                },

                fetchEvenements() {
                    this.loading = true;
                    fetch(`/evenements?page=${this.currentPage}&search=${this.search}`)
                        .then(response => response.json())
                        .then(data => {
                            this.evenements = data.data;
                            this.currentPage = data.current_page;
                            this.totalPages = data.last_page;
                            this.loading = false;
                        });
                },

                changePage(page) {
                    this.currentPage = page;
                    this.fetchEvenements();
                },

                openCreateModal() {
                    this.resetForm();
                    this.showCreateModal = true;
                },

                openEditModal(evenement) {
                    this.formData = { ...evenement };
                    this.showEditModal = true;
                },

                closeModal() {
                    this.showCreateModal = false;
                    this.showEditModal = false;
                    this.resetForm();
                },

                resetForm() {
                    this.formData = {
                        id: null,
                        type: '',
                        titre: '',
                        description: '',
                        adresse: '',
                        elements_requis: '',
                        nb_place: '',
                        date: ''
                    };
                    this.errors = {};
                },

                submitForm() {
                    const url = this.formData.id ? `/evenements/${this.formData.id}` : '/evenements';
                    const method = this.formData.id ? 'PUT' : 'POST';

                    fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(this.formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.errors) {
                            this.errors = data.errors;
                        } else {
                            this.closeModal();
                            this.fetchEvenements();
                            // Afficher un message de succès
                        }
                    });
                },

                confirmDelete(evenementId) {
                    this.eventToDelete = evenementId;
                    this.showDeleteModal = true;
                },

                deleteEvenement() {
                    fetch(`/evenements/${this.eventToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.showDeleteModal = false;
                        this.fetchEvenements();
                        // Afficher un message de succès
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>