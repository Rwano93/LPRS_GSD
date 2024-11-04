<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $evenement->titre }}</h1>
                        <span class="text-sm font-medium text-gray-500 bg-gray-100 rounded-full px-3 py-1">
                            {{ $evenement->type }}
                        </span>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-700 mb-2">Description</h2>
                        <p class="text-gray-600">{{ $evenement->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700 mb-2">Date et heure</h2>
                            <p class="text-gray-600 flex items-center">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $evenement->date->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700 mb-2">Adresse</h2>
                            <p class="text-gray-600 flex items-center">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $evenement->adresse }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Éléments requis</h2>
                        <p class="text-gray-600">{{ $evenement->elements_requis }}</p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Places disponibles</h2>
                        <p class="text-gray-600 flex items-center">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                            {{ $evenement->nb_place }}
                        </p>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            @if(Auth::user()->ref_role == 3 || Auth::user()->ref_role == 4)
                                <a href="{{ route('evenements.edit', $evenement) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                    Modifier
                                </a>
                                <button type="button"
                                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out"
                                    onclick="confirmDelete({{ $evenement->id }})">
                                    Supprimer
                                </button>
                            @endif
                        </div>
                        <div>
                            @if($evenement->date < now())
                                <span class="bg-gray-500 text-white font-bold py-2 px-4 rounded opacity-75">
                                    Clôturé
                                </span>
                            @else
                                @if(Auth::user()->id != $evenement->ref_user)
                                    @if($evenement->isUserInscrit(auth()->id()))
                                        <button onclick="confirmDesinscription({{ $evenement->id }})"
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                            Se désinscrire
                                        </button>
                                    @else
                                        <button onclick="confirmInscription({{ $evenement->id }})"
                                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out"
                                            {{ $evenement->nb_place <= 0 ? 'disabled' : '' }}>
                                            {{ $evenement->nb_place <= 0 ? 'Complet' : 'S\'inscrire' }}
                                        </button>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(evenementId) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + evenementId).submit();
                }
            });
        }

        function confirmInscription(evenementId) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Voulez-vous vous inscrire à cet événement ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, inscrire !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('inscription-form-' + evenementId).submit();
                }
            });
        }

        function confirmDesinscription(evenementId) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Voulez-vous vous désinscrire de cet événement ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, désinscrire !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('desinscription-form-' + evenementId).submit();
                }
            });
        }
    </script>

    <form id="delete-form-{{ $evenement->id }}" action="{{ route('evenements.destroy', $evenement) }}" method="POST"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <form id="inscription-form-{{ $evenement->id }}" action="{{ route('evenement.inscription', $evenement) }}"
        method="POST" style="display: none;">
        @csrf
    </form>
    <form id="desinscription-form-{{ $evenement->id }}" action="{{ route('evenement.desinscription', $evenement) }}"
        method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>