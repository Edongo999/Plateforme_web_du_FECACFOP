
<?php
header('Content-Type: application/json'); 
require_once 'connexion.php';

// 🔹 Inclusion de PHPMailer pour l'envoi des e-mails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 🔹 Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "rapcefop");
if ($conn->connect_error) {
    die(json_encode(["message" => "Erreur de connexion à la base de données."]));
}

// 🔹 Récupération des données du formulaire
$nom = htmlspecialchars(trim($_POST['name']));
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$pays = htmlspecialchars($_POST['pays']);
$cv = $_FILES['cv']['name'];
$offre_id = $_POST['offre_id'];
$date_submission = date('Y-m-d H:i:s');

// 🔹 Déplacement du fichier CV
$cv_path = "uploads/candidature/" . basename($cv);
move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path);

// 🔹 Vérification si le candidat a déjà postulé
$stmt = $conn->prepare("SELECT * FROM candidatures WHERE email = ? AND offre_id = ?");
$stmt->bind_param("si", $email, $offre_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["message" => "Vous avez déjà postulé pour cette offre."]);
} else {
    // 🔹 Insertion de la candidature en base
    $insert_stmt = $conn->prepare("INSERT INTO candidatures (nom, email, cv, date_submission, pays, offre_id) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("sssssi", $nom, $email, $cv_path, $date_submission, $pays, $offre_id);

    if ($insert_stmt->execute()) {
        // 🔹 Envoi d’un e-mail à l’administrateur
        try {
            $mailAdmin = new PHPMailer(true);
            $mailAdmin->isSMTP();
            $mailAdmin->Host = 'smtp.gmail.com';
            $mailAdmin->SMTPAuth = true;
            $mailAdmin->Username = 'landryamengne@gmail.com';
            $mailAdmin->Password = 'nsiz ixfk avcp esnc';
            $mailAdmin->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mailAdmin->Port = 587;

            $mailAdmin->setFrom('landryamengne@gmail.com', 'Plateforme Emploi');
            $mailAdmin->addAddress('landryamengne@gmail.com');

            $mailAdmin->isHTML(true);
            $mailAdmin->Subject = "Nouvelle candidature pour l’offre N° $offre_id";
            $mailAdmin->Body = "<h3>Un candidat a postulé !</h3>
                                <p><strong>Nom :</strong> $nom</p>
                                <p><strong>Email :</strong> $email</p>
                                <p><strong>Pays :</strong> $pays</p>";

            // 🔹 Attachement du CV
            $mailAdmin->addAttachment($cv_path);

            $mailAdmin->send();
        } catch (Exception $e) {
            error_log("Erreur d'envoi au gestionnaire : {$mailAdmin->ErrorInfo}");
        }

        // 🔹 Envoi d’un e-mail au candidat
        try {
            $mailUser = new PHPMailer(true);
            $mailUser->isSMTP();
            $mailUser->Host = 'smtp.gmail.com';
            $mailUser->SMTPAuth = true;
            $mailUser->Username = 'ton-email@gmail.com';
            $mailUser->Password = 'ton-mot-de-passe';
            $mailUser->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mailUser->Port = 587;

            $mailUser->setFrom('ton-email@gmail.com', 'Plateforme Emploi');
            $mailUser->addAddress($email);

            $mailUser->isHTML(true);
            $mailUser->Subject = "Confirmation de votre candidature";
            $mailUser->Body = "<h3>Merci $nom d’avoir postulé !</h3>
                               <p>Nous avons bien reçu votre candidature pour l’offre <strong>N° $offre_id</strong>.</p>
                               <p>Notre équipe examinera votre dossier et vous contactera si vous êtes sélectionné.</p>
                               <p>Bonne chance !</p>";

            $mailUser->send();
        } catch (Exception $e) {
            error_log("Erreur d'envoi au candidat : {$mailUser->ErrorInfo}");
        }

        echo json_encode(["message" => "Votre candidature a été envoyée avec succès !"]);
    } else {
        echo json_encode(["message" => "Une erreur est survenue lors de l’enregistrement."]);
    }
}

// 🔹 Fermeture des connexions
$stmt->close();
$conn->close();
?>
