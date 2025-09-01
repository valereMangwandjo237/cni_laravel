@extends("layouts.main_cni")

@section("content_main")

    <div class="container mt-5">
        <div class="row justify-content-center">
            <h1 class="text-center text-dark">Immatriculation</h1>
            <div class="col-md-5">
                <div class="card shadow p-4">
                    <h4 class="text-center mb-4 text-danger">Informations personnelles</h4>
                    <form method="POST" action="{{ route('dash_traiter', $immat->id) }}" id="immatrForm">
                        @csrf
                        <input type="hidden" name="action" id="form_action" value="">

                        <div class="mb-3">
                            <label for="name" class="form-label">Noms</label>
                            <input type="text" id="name" class="form-control" value="{{ $immat->nom }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénoms</label>
                            <input type="text" id="prenom" class="form-control" value="{{ $immat->prenom }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="lieu" class="form-label">Lieu de naissance</label>
                            <input type="text" id="lieu" class="form-control" value="{{ $immat->lieu_naissance }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="date_naiss" class="form-label">Date de naissance</label>
                            <input type="date" id="date_naiss" class="form-control" value="{{ $immat->date_naissance }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="id_cni" class="form-label">Numero de document</label>
                            <input type="text" id="id_cni" class="form-control" value="{{ $immat->numero_cni }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" id="email" class="form-control" value="{{ $immat->email }}" readonly>
                        </div>

                        <button type="button" class="btn btn-success w-100 mb-3" onclick="valider()">Valider l'immatriculation</button>
                        <button type="button" class="btn btn-danger w-100" onclick="rejeter()">Refuser l'immatriculation</button>

                        <div id="spinner" class="text-center my-3" style="display: none;">
                            <div class="spinner-border text-danger" role="status">
                                <span class="visually-hidden">Envoi du mail en cours...</span>
                            </div>
                            <p>Veillez patienter...</p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-5 justify-content-center align-items-center">
                <div id="photoPreview" class="text-center border rounded p-3 bg-white shadow" style="min-height: 300px; width: 100%;">
                    @foreach($immat->images as $image)
                        <a href="{{ asset('storage/' . $image->path) }}" target="_blank" style="display: block; margin-bottom: 20px;">
                            <img
                                src="{{ asset('storage/' . $image->path) }}"
                                alt="Photo {{ $image->type }}"
                                class="img-fluid rounded shadow"
                                style="max-height: 400px; width: auto; cursor: zoom-in;"
                            >
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function valider() {
            Swal.fire({
                title: "Confirmer la validation ?",
                icon: "success",
                showCancelButton: true,
                confirmButtonText: "Oui, valider",
                cancelButtonText: "Annuler"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("form_action").value = "valider";

                    document.getElementById("immatrForm").submit();
                }
            });
        }

        function rejeter() {
            Swal.fire({
                title: "Confirmer le rejet ?",
                text: "Un mail de refus sera envoyé à l'utilisateur.",
                icon: "error",
                showCancelButton: true,
                confirmButtonText: "Oui, rejeter",
                cancelButtonText: "Annuler"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("form_action").value = "rejeter";
                    // Affiche le spinner
                    document.getElementById('spinner').style.display = 'block';

                    // Soumet le formulaire
                    document.getElementById("immatrForm").submit();
                }
            });
        }
    </script>

@endsection
