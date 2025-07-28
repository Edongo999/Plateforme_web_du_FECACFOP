<?php
header('Content-Type: application/json');
require_once 'connexion.php';

// 🔹 Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 🔹 Vérifier et charger `config.php`
$configPath = __DIR__ . '/../../config/config.php';
if (!file_exists($configPath)) {
    die(json_encode(["success" => false, "message" => "❌ Erreur critique : Impossible de charger `config.php` !"]));
}
$config = include($configPath);
if (!is_array($config)) {
    die(json_encode(["success" => false, "message" => "❌ Erreur critique : `config.php` n'a pas retourné un tableau valide !"]));
}
$iv = substr($config['IV'], 0, 16); // 🔥 Correction de la longueur de l'IV

// 🔹 Vérifier que la requête est bien en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(["success" => false, "message" => "❌ Erreur : Ce script doit être exécuté via une requête POST !"]));
}

// 🔹 Sécurisation des données du formulaire
$nom_entreprise = htmlspecialchars(trim($_POST['nom_entreprise'] ?? ""));
$secteur = htmlspecialchars(trim($_POST['secteur'] ?? ""));
$statut_juridique = htmlspecialchars(trim($_POST['statut_juridique'] ?? ""));
$date_creation = htmlspecialchars($_POST['date_creation'] ?? "");
$adresse = htmlspecialchars($_POST['adresse'] ?? "");
$telephone = htmlspecialchars($_POST['telephone'] ?? "");
$email = filter_var($_POST['email'] ?? "", FILTER_VALIDATE_EMAIL) ? $_POST['email'] : null;

// 🔹 Vérification et chiffrement du site web
$site_web = isset($_POST['site_web']) && !empty($_POST['site_web']) 
    ? openssl_encrypt($_POST['site_web'], "AES-256-CBC", $config['SECRET_KEY'], 0, $iv) 
    : null;

// 🔹 Responsable
$nom_responsable = htmlspecialchars(trim($_POST['nom_responsable'] ?? ""));
$fonction = htmlspecialchars(trim($_POST['fonction'] ?? ""));
$contact_responsable = htmlspecialchars(trim($_POST['contact_responsable'] ?? ""));

// 🔹 Vérification de `email_responsable`
if (empty($_POST['email_responsable'])) {
    die(json_encode(["success" => false, "message" => "❌ Erreur : Le champ 'email_responsable' est obligatoire !"]));
}
$email_responsable_clair = $_POST['email_responsable']; // 🔥 Garde l'email en clair

//$email_responsable_chiffre = openssl_encrypt($_POST['email_responsable'], "AES-256-CBC", $config['SECRET_KEY'], 0, $iv);

// 🔹 Vérification des doublons
$stmt = $conn->prepare("SELECT id FROM entreprises WHERE LOWER(TRIM(nom_entreprise)) = ? LIMIT 1");
$stmt->bind_param("s", $nom_entreprise);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "⚠️ Cette entreprise est déjà enregistrée."]);
    exit;
}
$stmt->close();

// 🔹 Enregistrement des données sécurisées
$stmt = $conn->prepare("INSERT INTO entreprises (nom_entreprise, secteur, statut_juridique, date_creation, adresse, telephone, email, site_web, nom_responsable, fonction, contact_responsable, email_responsable) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssss", $nom_entreprise, $secteur, $statut_juridique, $date_creation, $adresse, $telephone, $email, $site_web, $nom_responsable, $fonction, $contact_responsable, $email_responsable_clair);

if ($stmt->execute()) {
    // 🔹 Déchiffrer l’email pour l’afficher dans la notification
    $email_responsable_clair = $email_responsable_clair; // 🔥 Il est déjà en clair, pas besoin de déchiffrer

  //  $email_responsable_clair = openssl_decrypt($email_responsable_chiffre, "AES-256-CBC", $config['SECRET_KEY'], 0, $iv);

    // 🔹 1️⃣ Envoi d'une notification **à l'administrateur + gestionnaire**
    try {
        $mailAdmin = new PHPMailer(true);
        $mailAdmin->isSMTP();
        $mailAdmin->Host = 'smtp.gmail.com';
        $mailAdmin->SMTPAuth = true;
        $mailAdmin->Username = $config['SMTP_USER'];
        $mailAdmin->Password = $config['SMTP_PASS'];
        $mailAdmin->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailAdmin->Port = 587;

        $mailAdmin->setFrom($config['SMTP_USER'], 'Plateforme FECACFOP');
        $mailAdmin->addAddress($config['ADMIN_EMAIL']);
        $mailAdmin->addAddress("gestionnaire@fecacfop.com"); // 🔹 Ajout du gestionnaire

        $mailAdmin->isHTML(true);
        $mailAdmin->Subject = '⚡ Nouvelle entreprise inscrite';
        $mailAdmin->Body = "<h3>Une nouvelle entreprise s'est inscrite !</h3>
                            <p><strong>Nom :</strong> $nom_entreprise</p>
                            <p><strong>Responsable :</strong> $nom_responsable</p>
                            <p><strong>Email :</strong> $email_responsable_clair</p>";

        $mailAdmin->send();
    } catch (Exception $e) {
        error_log("❌ Erreur d'envoi du message à l'administrateur : {$mailAdmin->ErrorInfo}");
    }

    // 🔹 2️⃣ Envoi d'un email **au responsable + l’entreprise**
    try {
        $mailEntreprise = new PHPMailer(true);
        $mailEntreprise->isSMTP();
        $mailEntreprise->Host = 'smtp.gmail.com';
        $mailEntreprise->SMTPAuth = true;
        $mailEntreprise->Username = $config['SMTP_USER'];
        $mailEntreprise->Password = $config['SMTP_PASS'];
        $mailEntreprise->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailEntreprise->Port = 587;

        $mailEntreprise->setFrom($config['SMTP_USER'], 'Plateforme FECACFOP');
        $mailEntreprise->addAddress($_POST['email_responsable']); // 🔹 Responsable
        $mailEntreprise->addAddress($_POST['email']); // 🔹 Email entreprise

        $mailEntreprise->isHTML(true);
        $mailEntreprise->Subject = '✅ Confirmation de votre inscription';
        $mailEntreprise->Body = "<h3>Bienvenue sur la Plateforme FECACFOP !</h3>
                                 <p><strong>Nom :</strong> $nom_entreprise</p>
                                 <p>Votre inscription a été enregistrée avec succès.</p>";

        $mailEntreprise->send();
    } catch (Exception $e) {
        error_log("❌ Erreur d'envoi à l'entreprise : {$mailEntreprise->ErrorInfo}");
    }

    echo json_encode(["success" => true, "message" => "✅ Inscription réussie avec notification envoyée !"]);
} else {
    echo json_encode(["success" => false, "message" => "❌ Erreur lors de l'enregistrement en base."]);
}

$stmt->close();
$conn->close();
?>












