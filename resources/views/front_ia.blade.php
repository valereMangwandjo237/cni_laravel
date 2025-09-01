<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Formulaire d'inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>

</head>
<body class="bg-light">

<div class="container mt-5">
    <img
    src="./assets/img/logo_dgi.png" alt="AdminLTE Logo" class=""
    width="20%" height="45%"/>
  <div class="row justify-content-center">
    <h1 class="text-center text-dark">Immatriculation</h1>
    <div class="col-md-5">
      <div class="card shadow p-4">
        <h4 class="text-center mb-4 text-danger">Informations personnelles</h4>
        <form action="#" method="POST" enctype="multipart/form-data" id="immatrForm">
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label">Noms</label>
            <input type="text" name="nom" id="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="prenom" class="form-label">Prénoms(Optionnel)</label>
            <input type="text" name="prenom" id="prenom" class="form-control">
          </div>

          <div class="mb-3">
            <label for="lieu" class="form-label">Lieu de naissance</label>
            <input type="text" name="lieu" id="lieu" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="date_naiss" class="form-label">Date de naissance</label>
            <input type="date" name="date_naiss" id="date_naiss" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="id_cni" class="form-label">Numero de document</label>
            <input type="text" name="id_cni" id="id_cni" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="nature" class="form-label">Nature de la piece d'identification</label>
            <select name="nature" id="nature" class="form-control" required>
                <option value="">-- Selectionner --</option>
                <option value="cni">CNI</option>
                <option value="passeport">Passeport</option>
                <option value="recepisse">Recepisse de CNI</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="photo_recto" class="form-label">Photo CNI - Recto</label>
            <input type="file" name="photo_recto" id="photo_recto" class="form-control" accept="image/*" required>
          </div>

          <div class="mb-3">
            <label for="photo_verso" class="form-label">Photo CNI - verso</label>
            <input type="file" name="photo_verso" id="photo_verso" class="form-control" accept="image/*" required>
          </div>

          <button type="submit" class="btn btn-danger w-100">Envoyer</button>
        </form>
      </div>
    </div>

    <div class="col-md-5 justify-content-center align-items-center">
        <div id="photoPreview" class="text-center border rounded p-3 bg-white shadow" style="min-height: 300px; width: 100%;">

            <img id="previewImage" src="" alt="Aperçu photo recto" class="img-fluid d-none" style="max-height: 250px;">

        </div>

        <!-- Spinner central -->
        <div id="spinnerOverlay" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex justify-content-center align-items-center" style="z-index: 9999;">
            <div class="spinner-border text-danger" role="status" aria-hidden="true"></div>
            <span class="ms-3 fs-4 text-danger">Analyse en cours...</span>
        </div>

        <!-- Réponse API -->
        <div id="apiResponse" class="ms-4 p-3 border rounded bg-light d-none" style="min-width: 300px;">
            <h5 class="mb-3 text-center">Résultat de l'analyse</h5>
            <p class="fw-bold text-danger fs-3 text-center"><span id="resp_type"></span></p>
            <div id="analyse_result">
                <p><strong>Confiance :</strong> <span id="resp_confiance"></span></p>
                <p><strong>Date d’expiration :</strong> <span id="resp_expiration"></span></p>
            </div>
        </div>

    </div>

  </div>

    <div class="row pt-5">
        <div class="col-12 col-md-10 offset-md-1">
            <p class="text-center fs-3 fw-bold">
                Probabilité de correspondance:
                <span id="resp_global" class="fw-bold"></span>%
            </p>
            <div class="progress" style="height: 30px;">
                <div id="scoreProgressBar" class="progress-bar bg-success" role="progressbar"
                    style="width: 0%;" aria-valuemin="0" aria-valuemax="100">
                0%
                </div>
            </div>
            <h3 class="mt-4 text-center text-danger">
                <span id="resp_interpretation" class="fw-bold"></span>
            </h3>
            <ul id="verificationList" class="list-group"></ul>
        </div>
    </div>
</div>

</body>

<script src="{{ asset('js/immatriculation.js') }}"></script>

</html>
