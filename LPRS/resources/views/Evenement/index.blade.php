<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-3xl font-semibold mb-6">Événements</h1>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 animate-fade-in-down" role="alert">
                        <p class="font-bold">Succès</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 animate-fade-in-down" role="alert">
                        <p class="font-bold">Erreur</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="mb-4 flex justify-between items-center">
                    <form action="{{ route('evenements.index') }}" method="GET" class="flex-grow mr-4">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Rechercher un événement" class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none focus:border-blue-500" value="{{ request('search') }}">
                            <button type="submit" class="absolute right-0 top-0 mt-2 mr-4">
                                <svg class="h-6 w-6 fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <a href="{{ route('evenements.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                        Créer un événement
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="evenements-container">
                    @foreach ($evenements as $evenement)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-xl animate-fade-in" id="evenement-{{ $evenement->id }}">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold mb-2">{{ $evenement->titre }}</h2>
                                <p class="text-gray-600 mb-4">{{ Str::limit($evenement->description, 100) }}</p>
                                <div class="text-sm text-gray-500 mb-2">
                                    <p>Type: {{ $evenement->type }}</p>
                                    <p>Date: {{ $evenement->date->format('d/m/Y H:i') }}</p>
                                    <p>Adresse: {{ $evenement->adresse }}</p>
                                    <p>Places restantes: {{ $evenement->nb_place }}</p>
                                </div>
                                <div class="mt-4 flex flex-wrap justify-between items-center">
                                    <div class="flex space-x-2 mb-2">
                                        <a href="{{ route('evenements.edit', $evenement) }}" class="text-yellow-600 hover:text-yellow-800 transition duration-300 ease-in-out transform hover:scale-110">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button class="text-red-600 hover:text-red-800 transition duration-300 ease-in-out transform hover:scale-110 delete-event" data-id="{{ $evenement->id }}">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if(Auth::check())
                                            @if($evenement->isUserInscrit())
                                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full text-sm transition duration-300 ease-in-out transform hover:scale-105 desinscription-btn" data-id="{{ $evenement->id }}">
                                                    Se désinscrire
                                                </button>
                                            @elseif($evenement->nb_place <= 0)
                                                <span class="bg-gray-500 text-white font-bold py-2 px-4 rounded-full text-sm opacity-75">
                                                    COMPLET
                                                </span>
                                            @else
                                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full text-sm transition duration-300 ease-in-out transform hover:scale-105 inscription-btn" data-id="{{ $evenement->id }}">
                                                    S'inscrire
                                                </button>
                                            @endif
                                        @endif
                                        <a href="{{ route('evenements.show', $evenement) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full text-sm transition duration-300 ease-in-out transform hover:scale-105">
                                            Voir plus
                                        </a>
                                        <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full text-sm transition duration-300 ease-in-out transform hover:scale-105 toggle-details" data-id="{{ $evenement->id }}">
                                            Détails
                                        </button>
                                    </div>
                                </div>
                                <div id="details-{{ $evenement->id }}" class="mt-4 hidden">
                                    <h3 class="font-semibold text-lg mb-2">Personnes inscrites:</h3>
                                    <ul class="list-disc list-inside" id="inscrits-list-{{ $evenement->id }}">
                                        <li>Chargement...</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $evenements->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-event');
            const inscriptionButtons = document.querySelectorAll('.inscription-btn');
            const desinscriptionButtons = document.querySelectorAll('.desinscription-btn');
            const toggleDetailsButtons = document.querySelectorAll('.toggle-details');

            function showConfirmationPopup(title, text, confirmButtonText, cancelButtonText, onConfirm) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: cancelButtonText
                }).then((result) => {
                    if (result.isConfirmed) {
                        onConfirm();
                    }
                });
            }

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const eventId = this.dataset.id;
                    showConfirmationPopup(
                        'Êtes-vous sûr ?',
                        'Voulez-vous vraiment supprimer cet événement ?',
                        'Oui, supprimer',
                        'Annuler',
                        () => {
                            axios.delete(`/evenements/${eventId}`)
                                .then(response => {
                                    const eventElement = document.getElementById(`evenement-${eventId}`);
                                    eventElement.style.transition = 'all 0.5s ease-in-out';
                                    eventElement.style.transform = 'scale(0.8)';
                                    eventElement.style.opacity = '0';
                                    setTimeout(() => {
                                        eventElement.remove();
                                    }, 500);
                                    Swal.fire('Supprimé !', 'L\'événement a été supprimé.', 'success');
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Erreur', 'Une erreur est survenue lors de la suppression de l\'événement.', 'error');
                                });
                        }
                    );
                });
            });

            inscriptionButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const eventId = this.dataset.id;
                    showConfirmationPopup(
                        'Confirmation d\'inscription',
                        'Êtes-vous sûr de vouloir vous inscrire à cet événement ?',
                        'Oui, m\'inscrire',
                        'Annuler',
                        () => {
                            axios.post(`/evenements/${eventId}/inscription`)
                                .then(response => {
                                    this.classList.add('animate-ping');
                                    setTimeout(() => {
                                        this.classList.remove('animate-ping');
                                        this.textContent = 'Se désinscrire';
                                        this.classList.remove('bg-green-500', 'hover:bg-green-700');
                                        this.classList.add('bg-red-500', 'hover:bg-red-700');
                                    }, 300);
                                    Swal.fire('Inscrit !', 'Vous êtes maintenant inscrit à l\'événement.', 'success');
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Erreur', 'Une erreur est survenue lors de l\'inscription.', 'error');
                                });
                        }
                    );
                });
            });

            desinscriptionButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const eventId = this.dataset.id;
                    showConfirmationPopup(
                        'Confirmation de désinscription',
                        'Êtes-vous sûr de vouloir vous désinscrire de cet événement ?',
                        'Oui, me désinscrire',
                        'Annuler',
                        () => {
                            axios.delete(`/evenements/${eventId}/desinscription`)
                                .then(response => {
                                    this.classList.add('animate-ping');
                                    setTimeout(() => {
                                        this.classList.remove('animate-ping');
                                        this.textContent = 'S\'inscrire';
                                        this.classList.remove('bg-red-500', 'hover:bg-red-700');
                                        this.classList.add('bg-green-500', 'hover:bg-green-700');
                                    }, 300);
                                    Swal.fire('Désinscrit !', 'Vous êtes maintenant désinscrit de l\'événement.', 'success');
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Erreur', 'Une erreur est survenue lors de la désinscription.', 'error');
                                });
                        }
                    );
                });
            });

            toggleDetailsButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const eventId = this.dataset.id;
                    const detailsDiv = document.getElementById(`details-${eventId}`);
                    const inscritsList = document.getElementById(`inscrits-list-${eventId}`);

                    if (detailsDiv.classList.contains('hidden')) {
                        detailsDiv.classList.remove('hidden');
                        this.textContent = 'Masquer';
                        
                        // Fetch registered users
                        axios.get(`/evenements/${eventId}/inscrits`)
                            .then(response => {
                                const inscrits = response.data;
                                inscritsList.innerHTML = '';
                                if (inscrits.length > 0) {
                                    inscrits.forEach(inscrit => {
                                        inscritsList.innerHTML += `<li>${inscrit.name} - ${inscrit.email}</li>`;
                                    });
                                } else {
                                    inscritsList.innerHTML =   '<li>Aucune personne inscrite</li>';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                inscritsList.innerHTML = '<li>Erreur lors du chargement des inscrits</li>';
                            });
                    } else {
                        detailsDiv.classList.add('hidden');
                        this.textContent = 'Détails';
                    }
                });
            });
        });
    </script>

    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.5s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes ping {
            75%, 100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        .animate-ping {
            animation: ping 0.3s cubic-bezier(0, 0, 0.2, 1);
        }
    </style>
</x-app-layout>