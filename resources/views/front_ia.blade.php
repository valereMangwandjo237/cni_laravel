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

<script>
    function getType(name, confiance) {
        if (confiance >= 0.80) {
            if (name === "others") {
                return "BLOQUE!!";
            } else {
                return "VALIDE!!";
            }
        } else {
            return "A VERIFIER AU POOL";
        }
    }

    function getStatus(type){
        if (type == "VALIDE!!") {
            return 0;
        }else if(type == "BLOQUE!!"){
            return 1;
        }else{ return 2; }
    }


    document.getElementById("immatrForm").addEventListener("submit", async function(event) {
        event.preventDefault();
        //je cache la bloc qui affiche les informations
        $('#analyse_result').hide();

        const responseDiv = document.getElementById("apiResponse");
        const previewDiv = document.getElementById("photoPreview");
        const verificationList = document.getElementById("verificationList");

        // Réinitialisation de l'affichage
        responseDiv.classList.add("d-none");
        previewDiv.querySelector("#previewImage").classList.add("d-none");
        previewDiv.querySelector("#previewImage").src = "";
        verificationList.innerHTML = "";

        const formData = new FormData();
        formData.append("recto", document.getElementById("photo_recto").files[0]);
        formData.append("verso", document.getElementById("photo_verso").files[0]);

        // Récupérer la date et la formater
        const dateNaiss = document.getElementById("date_naiss").value; // format YYYY-MM-DD
        let dateFormatee = "";
        if (dateNaiss) {
            const parts = dateNaiss.split("-");
            dateFormatee = `${parts[2]}.${parts[1]}.${parts[0]}`; // DD.MM.YYYY
        }



        const data = {
            nom: document.getElementById("name").value,
            prenom: document.getElementById("prenom").value,
            lieu_de_naisance: document.getElementById("lieu").value,
            numero: document.getElementById("id_cni").value,
            date_de_naissance: dateFormatee
        };

        formData.append("data", JSON.stringify(data));
        console.log("Date envoyée: " + dateFormatee);

        try {
            $('#spinnerOverlay').removeClass('d-none');
            const response = await fetch("http://127.0.0.1:5000/analyser", {
                method: "POST",
                body: formData
            });

            if (!response.ok) {
                throw new Error(`Erreur API: ${response.statusText}`);
            }

            const result = await response.json();

            // Affichage de l'image
            const file = document.getElementById("photo_recto").files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = previewDiv.querySelector("#previewImage");
                    img.src = e.target.result;
                    img.classList.remove("d-none");
                };
                reader.readAsDataURL(file);
            }

            responseDiv.classList.remove("d-none");
            let type_mod = getType(result.type_document, result.confiance || 0);
            if (result.score_global != -1 && result.score_global != -2) {
                // Affichage des résultats
                $('#analyse_result').show();   // jaffiche le bloc qui porte les info si la photo est bonnne

                document.getElementById("resp_type").textContent = type_mod || '';
                document.getElementById("resp_confiance").textContent = result.confiance ?? '';
                document.getElementById("resp_interpretation").textContent = result.interpretation || '';
                document.getElementById("resp_expiration").textContent = result.date_expiration || '';
                document.getElementById("resp_global").textContent = result.score_global || '';


                //barre de progression
                const score = result.score_global || 0;
                const progressBar = document.getElementById("scoreProgressBar");

                progressBar.style.width = score + "%";
                progressBar.setAttribute("aria-valuenow", score);
                progressBar.textContent = score + "%";

                // Mise à jour de la couleur
                progressBar.classList.remove("bg-success", "bg-warning", "bg-danger");
                if (score >= 80) {
                    progressBar.classList.add("bg-success");
                } else if (score >= 50) {
                    progressBar.classList.add("bg-warning");
                } else {
                    progressBar.classList.add("bg-danger");
                }



                //Affichage détaillé des vérifications
                const verification = result.verification_informations || {};
                verificationList.innerHTML = Object.entries(verification).map(([key, value], index) => {
                    return `
                        <li class="list-group-item ${index % 2 === 0 ? 'bg-light' : 'bg-white'}">
                            <strong>${key} :</strong><br>
                            Valeur OCR : <em>${value.valeur_ocr}</em><br>
                            Score : ${value.score}%<br>
                            Valide : ${value.valide ? '✅' : '❌'}
                        </li>
                    `;
                }).join('');
            }else if(result.score_global == -1){
                type_mod = "BLOQUE!!";
                document.getElementById("resp_type").textContent = "BLOQUE!!";
            }else{
                type_mod = "A VERIFIER AU POOL";
                document.getElementById("resp_type").textContent = "A VERIFIER AU POOL";
            }

            console.log("Type du document: " + type_mod);



            // 💾 → ENREGISTREMENT Laravel ici si tout est OK
            const formToLaravel = new FormData();
            formToLaravel.append("nom", document.getElementById("name").value);
            formToLaravel.append("prenom", document.getElementById("prenom").value);
            formToLaravel.append("lieu_de_naissance", document.getElementById("lieu").value);
            formToLaravel.append("email", document.getElementById("email").value);
            formToLaravel.append("numero", document.getElementById("id_cni").value);
            formToLaravel.append("date_de_naissance", document.getElementById("date_naiss").value);
            formToLaravel.append("photo_recto", document.getElementById("photo_recto").files[0]);
            formToLaravel.append("photo_verso", document.getElementById("photo_verso").files[0]);
            formToLaravel.append("status", getStatus(type_mod));

            // Envoi vers Laravel (assure-toi que la route /enregistrer existe côté Laravel)
            fetch("/enregistrer", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formToLaravel
            })
            .then(r => r.json())
            .then(data => {
                console.log("✅ Enregistrement Laravel :", data);
            })
            .catch(err => {
                console.error("❌ Erreur Laravel :", err);
            });

        } catch (error) {
            responseDiv.classList.remove("d-none");
            responseDiv.innerHTML = `<p class="text-danger">Erreur lors de l'analyse : ${error.message}</p>`;
        } finally {
            // Cacher spinner ici si besoin
            $('#spinnerOverlay').addClass('d-none');
    }
});


</script>

</body>
</html>
