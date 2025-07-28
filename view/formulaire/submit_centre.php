
<?php
header('Content-Type: application/json'); 
require_once 'connexion.php';

// 🔹 Désactiver l'affichage d'erreurs pour éviter du contenu non JSON
error_reporting(E_ALL);
ini_set('display_errors', 0);
ob_start();

// 🔹 Vérifier que la requête est bien POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Requête invalide."]);
    exit;
}

// 🔹 Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 🔹 Sécurisation des données
$nom_centre = htmlspecialchars(trim($_POST['nom_centre']));
$secteur = htmlspecialchars(trim($_POST['secteur']));
$statut = htmlspecialchars(trim($_POST['statut']));
$date_creation = htmlspecialchars($_POST['date_creation']);
$adresse = htmlspecialchars($_POST['adresse']);
$telephone = htmlspecialchars($_POST['telephone']);
$email_centre = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$site_web = isset($_POST['site_web']) && !empty(trim($_POST['site_web'])) ? htmlspecialchars($_POST['site_web']) : NULL;
$nom_responsable = htmlspecialchars(trim($_POST['nom_responsable']));
$fonction = htmlspecialchars(trim($_POST['fonction']));
$contact_responsable = htmlspecialchars(trim($_POST['contact_responsable']));
$email_responsable = filter_var($_POST['email_responsable'], FILTER_VALIDATE_EMAIL);
$nombre_etudiants = isset($_POST['nombre_etudiants']) && $_POST['nombre_etudiants'] !== "" ? (int) $_POST['nombre_etudiants'] : NULL;
$nombre_formateurs = isset($_POST['nombre_formateurs']) && $_POST['nombre_formateurs'] !== "" ? (int) $_POST['nombre_formateurs'] : NULL;
$types_formations = isset($_POST['types_formations']) && !empty(trim($_POST['types_formations'])) ? htmlspecialchars($_POST['types_formations']) : NULL;
$langue_enseignement = isset($_POST['langue_enseignement']) && !empty(trim($_POST['langue_enseignement'])) ? htmlspecialchars($_POST['langue_enseignement']) : NULL;
$certifications = isset($_POST['certifications']) && !empty(trim($_POST['certifications'])) ? htmlspecialchars($_POST['certifications']) : NULL;
$agrements = isset($_POST['agrements']) && !empty(trim($_POST['agrements'])) ? htmlspecialchars($_POST['agrements']) : NULL;

// 🔹 Vérification stricte des champs obligatoires
$nom_centre_clean = strtolower(trim($_POST['nom_centre'])); // 🔹 Nettoie le nom avant la vérification

$stmt = $conn->prepare("SELECT id FROM centres_formation WHERE LOWER(TRIM(nom_centre)) = ? LIMIT 1");
$stmt->bind_param("s", $nom_centre_clean);
$stmt->execute();
$stmt->store_result();

error_log("🛠 Vérification du centre : Nom = " . $nom_centre_clean . " | Nombre de résultats = " . $stmt->num_rows); // ✅ Debug

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Ce centre est déjà enregistré."]);
    exit;
}
$stmt->close();

// 🔹 Insertion des données
$stmt = $conn->prepare("INSERT INTO centres_formation (nom_centre, secteur, statut, date_creation, adresse, telephone, email, site_web, nom_responsable, fonction, contact_responsable, email_responsable, nombre_etudiants, nombre_formateurs, types_formations, langue_enseignement, certifications, agrements) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssssisssss", $nom_centre, $secteur, $statut, $date_creation, $adresse, $telephone, $email_centre, $site_web, $nom_responsable, $fonction, $contact_responsable, $email_responsable, $nombre_etudiants, $nombre_formateurs, $types_formations, $langue_enseignement, $certifications, $agrements);

if ($stmt->execute()) {
    // 🔹 1️⃣ Envoi d'un e-mail à l'administrateur 📩
    try {
        $mailAdmin = new PHPMailer(true);
        $mailAdmin->isSMTP();
        $mailAdmin->Host = 'smtp.gmail.com';
        $mailAdmin->SMTPAuth = true;
        $mailAdmin->Username = 'landryamengne@gmail.com';
        $mailAdmin->Password = 'nsiz ixfk avcp esnc';
        $mailAdmin->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailAdmin->Port = 587;

        $mailAdmin->setFrom('landryamengne@gmail.com', 'Inscription Centre');
        $mailAdmin->addAddress('landryamengne@gmail.com');

        $mailAdmin->isHTML(true);
        $mailAdmin->Subject = '⚡ Nouveau Centre de Formation Inscrit';
        $mailAdmin->Body    = "<h3>Un nouveau centre s'est inscrit !</h3>
                               <p><strong>Nom du Centre :</strong> $nom_centre</p>";

        $mailAdmin->send();
    } catch (Exception $e) {
        error_log("❌ Erreur d'envoi du message à l'administrateur : {$mailAdmin->ErrorInfo}");
    }

    // 🔹 2️⃣ Envoi d'un e-mail au responsable et au centre 📩
    try {
        $mailResponsable = new PHPMailer(true);
        $mailResponsable->isSMTP();
        $mailResponsable->Host = 'smtp.gmail.com';
        $mailResponsable->SMTPAuth = true;
        $mailResponsable->Username = 'landryamengne@gmail.com';
        $mailResponsable->Password = 'nsiz ixfk avcp esnc';
        $mailResponsable->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailResponsable->Port = 587;

        $mailResponsable->setFrom('landryamengne@gmail.com', 'Fédération des Centres de Formation');
        $mailResponsable->addAddress($email_responsable);
        $mailResponsable->addAddress($email_centre);

        $mailResponsable->isHTML(true);
        $mailResponsable->Subject = '✅ Confirmation de votre inscription';
        $mailResponsable->Body    = "<h3>Bienvenue dans la Fédération des Centres de Formation !</h3>
                                    <p><strong>Nom du Centre :</strong> $nom_centre</p>";

        $mailResponsable->send();
    } catch (Exception $e) {
        error_log("❌ Erreur d'envoi au responsable et au centre : {$mailResponsable->ErrorInfo}");
    }

    echo json_encode([
    "success" => true,
    "message" => "Inscription réussie !",
    "redirect" => "confirmation.php",
    "showCheck" => true
]);

   //echo json_encode(["success" => true, "message" => "Inscription réussie !", "redirect" => "confirmation.php"]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur lors de l'enregistrement."]);
}

$stmt->close();
$conn->close();
?>
