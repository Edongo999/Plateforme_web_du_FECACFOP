<?php
// Activer l'affichage des erreurs pour diagnostic
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérification du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "rapcefop");

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // Affichage des données envoyées pour debug
    var_dump($_POST);
    var_dump($_FILES);

    // Récupération des données du formulaire
    $titre = $_POST['titre'] ?? null;
    $contenu = $_POST['contenu'] ?? null;
    $type_publication = $_POST['type_publication'] ?? null;
    $type_media = $_POST['type_media'] ?? null;
    $date_debut = $_POST['date_debut'] ?? null;
    $date_fin = $_POST['date_fin'] ?? null;
    $media = $_FILES['media'] ?? null;

    if ($titre && $type_publication && $type_media && $media) {
        $target_dir = "uploads/" . $type_publication . "/";
        
        // Création du répertoire si inexistant
        if (!is_dir($target_dir) && !mkdir($target_dir, 0777, true)) {
            die("Erreur : Impossible de créer le répertoire cible.");
        }

        // Nom complet du fichier (chemin)
        $target_file = $target_dir . basename($media['name']);

        // Déplacer le fichier dans le répertoire approprié
        if (move_uploaded_file($media['tmp_name'], $target_file)) {
            $date_publication = date("Y-m-d H:i:s");

            // Préparation de la requête selon le type de publication
            if ($type_publication === 'actualite') {
                $stmt = $conn->prepare("INSERT INTO actualites1 (titre, contenu, date_publication, type_media, media) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $titre, $contenu, $date_publication, $type_media, $target_file);
            } elseif ($type_publication === 'emploi') {
                $stmt = $conn->prepare("INSERT INTO emplois (titre, description, date_publication, media) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $titre, $contenu, $date_publication, $target_file);
            } elseif ($type_publication === 'publicite' && $date_debut && $date_fin) { 
                // Vérification des dates de début et fin avant insertion
                if (!$date_debut || !$date_fin) {
                    die("Erreur : Les champs date de début et date de fin sont requis pour les publicités.");
                }

                $statut = "actif"; 
                $stmt = $conn->prepare("INSERT INTO publicites (titre, media_type, media_path, date_debut, date_fin, statut) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $titre, $type_media, $target_file, $date_debut, $date_fin, $statut);
            } else {
                die("Erreur : Les champs nécessaires pour les publicités ne sont pas remplis.");
            }

            // Exécution de la requête et affichage des erreurs SQL
            if ($stmt->execute()) {
                echo "Publication ajoutée avec succès !";
            } else {
                echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
            }
            $stmt->close();
        } else {
            die("Erreur : Impossible de déplacer le fichier téléchargé.");
        }
    } else {
        die("Erreur : Informations manquantes dans le formulaire.");
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une publication</title>
    <link rel="stylesheet" href="../public/assets/css_actualites/style1.css"> <!-- Assurez-vous que le chemin vers le fichier CSS est correct -->
    <style>
        /* Animation et styles pour la notification */
        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 20px;
            border-radius: 8px;
            font-size: 16px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
            display: none; /* Masqué par défaut */
            z-index: 1000;
        }

        .notification.success {
            background-color: #4caf50; /* Vert pour succès */
        }

        .notification.error {
            background-color: #f44336; /* Rouge pour erreur */
        }

        .notification.show {
            display: block; /* Affiche la notification */
            animation: fadeIn 0.5s ease-out, fadeOut 0.5s ease-in 4s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        /* Masquer les champs de publicité par défaut */
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Publier une publication</h1>
    </header>
    <main class="container">
        <!-- Notification dynamique -->
        <div id="notification" class="notification"></div>

        <form action="" method="POST" enctype="multipart/form-data" class="form-publier">
            <!-- Type de publication -->
            <div class="form-group">
                <label for="type_publication">Type de publication :</label>
                <select id="type_publication" name="type_publication" required onchange="toggleFields()">
                    <option value="actualite">Actualité (Image/Vidéo)</option>
                    <option value="emploi">Offre d'Emploi</option>
                    <option value="publicite">Publicité</option> <!-- Ajout du type publicité -->
                </select>
            </div>

            <!-- Titre -->
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" placeholder="Entrez un titre" required>
            </div>

            <!-- Contenu (Affiché pour Actualités et Emplois uniquement) -->
            <div id="contenuFields">
                <div class="form-group">
                    <label for="contenu">Description ou contenu :</label>
                    <textarea id="contenu" name="contenu" rows="5" placeholder="Entrez le contenu..." required></textarea>
                </div>
            </div>

            <!-- Champs spécifiques à la publicité -->
            <div id="publiciteFields" class="hidden">
                <div class="form-group">
                    <label for="date_debut">Date de début :</label>
                    <input type="date" id="date_debut" name="date_debut">
                </div>
                <div class="form-group">
                    <label for="date_fin">Date de fin :</label>
                    <input type="date" id="date_fin" name="date_fin">
                </div>
            </div>

            <!-- Type de média -->
            <div id="media-options" class="form-group">
                <label for="type_media">Type de média :</label>
                <select id="type_media" name="type_media">
                    <option value="image">Image</option>
                    <option value="video">Vidéo</option>
                </select>
            </div>

            <!-- Fichier -->
            <div class="form-group">
                <label for="media">Fichier :</label>
                <input type="file" id="media" name="media" accept="image/*,video/*" required>
            </div>

            <button type="submit" class="btn-submit">Publier</button>
        </form>
    </main>


      <script>
function toggleFields() {
    let typePublication = document.getElementById("type_publication").value;
    let publiciteFields = document.getElementById("publiciteFields");
    let contenuFields = document.getElementById("contenuFields");

    // MASQUER le champ contenu uniquement pour les publicités
    if (typePublication === "publicite") {
        contenuFields.classList.add("hidden"); 
        document.getElementById("contenu").removeAttribute("required"); // Supprimer l'obligation du champ contenu
        document.getElementById("contenu").value = ""; // Effacer son contenu
    } else {
        contenuFields.classList.remove("hidden"); 
        document.getElementById("contenu").setAttribute("required", "true"); // Le rendre obligatoire pour les autres types de publication
    }

    publiciteFields.classList.toggle("hidden", typePublication !== "publicite");
}

    </script>
    

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const showNotification = (message, type = "success") => {
                const notification = document.getElementById("notification");
                notification.textContent = message;
                notification.className = `notification ${type} show`;

                // Masquer la notification après 3,5 secondes
                setTimeout(() => {
                    notification.className = "notification";
                }, 3500);
            };

            const form = document.querySelector(".form-publier");
            form.addEventListener("submit", (event) => {
                event.preventDefault();

                const formData = new FormData(form);

                fetch("", {
                    method: "POST",
                    body: formData,
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data.includes("Publication ajoutée avec succès")) {
                            showNotification("Publication ajoutée avec succès !", "success");
                            form.reset();
                        } else {
                            showNotification(`Erreur lors de la publication : ${data}`, "error");
                        }
                    })
                    .catch(() => {
                        showNotification("Erreur réseau. Réessayez.", "error");
                    });
            });
        });
    </script>
     <script>
       function toggleFields() {
    let typePublication = document.getElementById("type_publication").value;
    let publiciteFields = document.getElementById("publiciteFields");
    let contenuFields = document.getElementById("contenuFields");

    // Toujours afficher le champ contenu
    contenuFields.classList.remove("hidden");

    // Gérer les champs spécifiques aux publicités
    publiciteFields.classList.toggle("hidden", typePublication !== "publicite");

    // Réinitialiser les champs quand on change de type
    document.getElementById("titre").value = "";
    document.getElementById("contenu").value = "";
    document.getElementById("date_debut").value = "";
    document.getElementById("date_fin").value = "";
    document.getElementById("type_media").selectedIndex = 0;
    document.getElementById("media").value = "";
}
</script>
</body>
</html>
