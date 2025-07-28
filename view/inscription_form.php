

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Multi-Étapes</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 20px;
}

form {
    max-width: 500px;
    margin: auto;
}

fieldset {
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    display: none; /* 🔹 Cache toutes les étapes sauf la première */
}

fieldset.active, .form-step:first-child {
    display: block !important; /* 🔥 Affiche la première étape */
}

button {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

    </style>

<form id="inscription-form" action="../index.php?action=inscription" method="post">
    <div class="form-step active">
        <fieldset>
            <legend>Informations personnelles</legend>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="date-naissance">Date de naissance :</label>
            <input type="date" id="date-naissance" name="date_naissance" required>

            <label for="sexe">Sexe :</label>
            <select id="sexe" name="sexe" required>
                <option value="">Choisissez...</option>
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
            </select>

            <button type="button" class="next-btn">Suivant</button>
        </fieldset>
    </div>

    <div class="form-step">
        <fieldset>
            <legend>Coordonnées</legend>
            <label for="nationalite">Nationalité :</label>
            <input type="text" id="nationalite" name="nationalite" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="telephone">Téléphone :</label>
            <input type="tel" id="telephone" name="telephone" required>

            <label for="adresse">Adresse :</label>
            <textarea id="adresse" name="adresse" required></textarea>

            <button type="button" class="prev-btn">Précédent</button>
            <button type="button" class="next-btn">Suivant</button>
        </fieldset>
    </div>

    <div class="form-step">
        <fieldset>
            <legend>Formation</legend>
            <label for="programme">Programme :</label>
            <select id="programme" name="programme" required>
                <option value="web">Développement Web</option>
                <option value="marketing">Marketing Digital</option>
            </select>

            <label for="centre">Centre :</label>
            <select id="centre" name="centre" required>
                <option value="Douala">Douala</option>
                <option value="Yaoundé">Yaoundé</option>
            </select>

            <label for="motivations">Motivations :</label>
            <textarea id="motivations" name="motivations"></textarea>

            <button type="button" class="prev-btn">Précédent</button>
            <button type="submit">Valider l'inscription</button>
        </fieldset>
    </div>
</form>



<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ JavaScript chargé !");

    const formSteps = document.querySelectorAll(".form-step");
    const nextButtons = document.querySelectorAll(".next-btn");
    const prevButtons = document.querySelectorAll(".prev-btn");
    let currentStep = 0;

    const updateStep = () => {
        formSteps.forEach((step, index) => {
            step.style.display = index === currentStep ? "block" : "none"; // ✅ Affichage contrôlé
        });
    };

    const isStepValid = () => {
        const inputs = formSteps[currentStep].querySelectorAll("input[required], select[required], textarea[required]");
        return Array.from(inputs).every(input => input.value.trim() !== "");
    };

    nextButtons.forEach(button => {
        button.addEventListener("click", () => {
            if (!isStepValid()) {
                alert("❌ Veuillez remplir tous les champs avant de continuer.");
                return;
            }
            currentStep++;
            updateStep();
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener("click", () => {
            currentStep--;
            updateStep();
        });
    });

    updateStep();
});


</script>
</body>
</html>

