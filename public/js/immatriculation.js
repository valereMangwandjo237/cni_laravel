
function getType(name, confiance) {
    if (confiance >= 0.80) {
        return name === "others" ? "BLOQUE!!" : "VALIDE!!";
    } else {
        return "A VERIFIER AU POOL";
    }
}

function getStatus(type, interpretation) {
    if (type === "VALIDE!!" && interpretation=="PROFIL VALIDE !!") return 0;
    if (type === "BLOQUE!!" || interpretation=="PROFIL BLOQUE!!!") return 1;
    if (type === "A VERIFIER AU POOL" || interpretation=="vérification recommandée au POOL") return 2;

}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("immatrForm");
    if (!form) return;

    form.addEventListener("submit", async function (event) {
        event.preventDefault();
        $('#analyse_result').hide();

        const responseDiv = document.getElementById("apiResponse");
        const previewDiv = document.getElementById("photoPreview");
        const verificationList = document.getElementById("verificationList");

        if (responseDiv) responseDiv.classList.add("d-none");
        if (previewDiv) {
            const img = previewDiv.querySelector("#previewImage");
            if (img) {
                img.classList.add("d-none");
                img.src = "";
            }
        }
        if (verificationList) verificationList.innerHTML = "";

        const formData = new FormData();
        formData.append("recto", document.getElementById("photo_recto")?.files[0]);
        formData.append("verso", document.getElementById("photo_verso")?.files[0]);

        const dateNaiss = document.getElementById("date_naiss")?.value || "";
        let dateFormatee = "";
        if (dateNaiss) {
            const parts = dateNaiss.split("-");
            if (parts.length === 3) {
                dateFormatee = `${parts[2]}.${parts[1]}.${parts[0]}`;
            }
        }

        const data = {
            nom: document.getElementById("name")?.value || "",
            prenom: document.getElementById("prenom")?.value || "",
            lieu_de_naisance: document.getElementById("lieu")?.value || "",
            numero: document.getElementById("id_cni")?.value || "",
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

            // Affichage image
            const file = document.getElementById("photo_recto")?.files[0];
            if (file && previewDiv) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = previewDiv.querySelector("#previewImage");
                    if (img) {
                        img.src = e.target.result;
                        img.classList.remove("d-none");
                    }
                };
                reader.readAsDataURL(file);
            }

            if (responseDiv) responseDiv.classList.remove("d-none");

            let type_mod = getType(result.type_document, result.confiance || 0);

            if (result.score_global !== -1 && result.score_global !== -2) {
                $('#analyse_result').show();

                const safeSet = (id, value) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = value ?? '';
                };

                safeSet("resp_type", type_mod);
                safeSet("resp_confiance", result.confiance);
                safeSet("resp_interpretation", result.interpretation);
                safeSet("resp_expiration", result.date_expiration);
                safeSet("resp_global", result.score_global);

                // Barre de progression
                const score = result.score_global || 0;
                const progressBar = document.getElementById("scoreProgressBar");
                if (progressBar) {
                    progressBar.style.width = score + "%";
                    progressBar.setAttribute("aria-valuenow", score);
                    progressBar.textContent = score + "%";
                    progressBar.classList.remove("bg-success", "bg-warning", "bg-danger");
                    progressBar.classList.add(
                        score >= 80 ? "bg-success" :
                        score >= 50 ? "bg-warning" :
                        "bg-danger"
                    );
                }

                // Liste de vérification
                const verification = result.verification_informations || {};
                if (verificationList) {
                    verificationList.innerHTML = Object.entries(verification).map(([key, value], index) => `
                        <li class="list-group-item ${index % 2 === 0 ? 'bg-light' : 'bg-white'}">
                            <strong>${key} :</strong><br>
                            Valeur OCR : <em>${value.valeur_ocr}</em><br>
                            Score : ${value.score}%<br>
                            Valide : ${value.valide ? '✅' : '❌'}
                        </li>
                    `).join('');
                }
            } else {
                const typeText = result.score_global === -1 ? "BLOQUE!!" : "A VERIFIER AU POOL";
                type_mod = typeText;
                const el = document.getElementById("resp_type");
                if (el) el.textContent = typeText;
            }

            console.log("Type du document: " + type_mod);

            // 💾 → ENREGISTREMENT Laravel ici si c'est pas un others
            if (result.score_global != -1) {
                const formToLaravel = new FormData();
                formToLaravel.append("nom", document.getElementById("name").value);
                formToLaravel.append("prenom", document.getElementById("prenom").value);
                formToLaravel.append("lieu_de_naissance", document.getElementById("lieu").value);
                formToLaravel.append("email", document.getElementById("email").value);
                formToLaravel.append("numero", document.getElementById("id_cni").value);
                formToLaravel.append("date_de_naissance", document.getElementById("date_naiss").value);
                formToLaravel.append("nature", document.getElementById("nature").value);
                formToLaravel.append("photo_recto", document.getElementById("photo_recto").files[0]);
                formToLaravel.append("photo_verso", document.getElementById("photo_verso").files[0]);
                formToLaravel.append("status", getStatus(type_mod, result.interpretation));

                // Envoi vers Laravel (assure-toi que la route /enregistrer existe côté Laravel)
                fetch("/enregistrer", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formToLaravel
                })
                .then(async (response) => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error("Erreur serveur Laravel : " + text);
                    }
                    return response.json();  // OK si Laravel retourne bien du JSON
                })
                .then(data => {
                    console.log("✅ Enregistrement Laravel :", data);
                })
                .catch(err => {
                    console.error("❌ Erreur Laravel :", err.message);
                });

            }



        } catch (error) {
            if (responseDiv) {
                responseDiv.classList.remove("d-none");
                responseDiv.innerHTML = `<p class="text-danger">Erreur lors de l'analyse : ${error.message}</p>`;
            }
        } finally {
            $('#spinnerOverlay').addClass('d-none');
        }
    });
});
