<?php
header('Content-Type: application/json'); 
require_once 'connexion.php';

// 🔹 Ajout de logs pour vérifier si les données arrivent
error_log("🔹 Données reçues : " . json_encode($_POST));

// Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $nom = htmlspecialchars(trim($_POST['nom']));
    $date_naissance = htmlspecialchars($_POST['date-naissance']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $regions = htmlspecialchars($_POST['region']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $telephone = htmlspecialchars($_POST['telephone']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $programme = htmlspecialchars($_POST['programme']);
    $centre = htmlspecialchars($_POST['centre']);
    $motivations = htmlspecialchars($_POST['motivations']);

    // 🔹 Vérification stricte des champs obligatoires
    if (empty($prenom) || empty($nom) || empty($date_naissance) || empty($sexe) || empty($regions) || !$email || empty($telephone) || empty($programme) || empty($centre)) {
        echo json_encode(["success" => false, "message" => "Veuillez remplir tous les champs obligatoires."]);
        exit;
    }

    // 🔹 Vérification stricte du format d'e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "L'adresse e-mail n'est pas valide."]);
        exit;
    }

    // 🔹 Vérification du téléphone (uniquement chiffres et +)
    if (!preg_match("/^\+?[0-9]{10,15}$/", $telephone)) {
        echo json_encode(["success" => false, "message" => "Le numéro de téléphone n'est pas valide."]);
        exit;
    }

    // 🔹 Vérification de la présence d'un candidat déjà inscrit
    $stmt = $conn->prepare("SELECT COUNT(*) FROM etudiants WHERE nom = ? AND prenom = ?");
    $stmt->bind_param("ss", $nom, $prenom);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo json_encode(["success" => false, "message" => "Vous êtes déjà inscrit avec ce nom et prénom."]);
        exit;
    }

    // 🔹 Insertion des données en base
    $stmt = $conn->prepare("INSERT INTO etudiants (prenom, nom, date_naissance, sexe, regions, email, telephone, adresse, programme, centre, motivations) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $prenom, $nom, $date_naissance, $sexe, $regions, $email, $telephone, $adresse, $programme, $centre, $motivations);

    if ($stmt->execute()) {
        // 🔹 Envoi d'un e-mail à l'administrateur 📩
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'landryamengne@gmail.com'; // Ton adresse e-mail
            $mail->Password   = 'nsiz ixfk avcp esnc'; // Mot de passe d'application Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // 🔹 Paramètres de l'expéditeur et du destinataire (admin)
            $mail->setFrom('landryamengne@gmail.com', 'Inscription Automatique ');
            $mail->addAddress('landryamengne@gmail.com'); // Email administrateur

            // 🔹 Contenu du message
            $mail->isHTML(true);
            $mail->Subject = 'Nouvelle inscription';
            $mail->Body    = "<h3>Un nouveau candidat s'est inscrit !</h3>
                              <p><strong>Prénom :</strong> $prenom</p>
                              <p><strong>Nom :</strong> $nom</p>
                              <p><strong>Email :</strong> $email</p>
                              <p><strong>Téléphone :</strong> $telephone</p>
                              <p><strong>Programme :</strong> $programme</p>
                              <p><strong>Centre :</strong> $centre</p>";

            $mail->send();

        } catch (Exception $e) {
            error_log("Erreur d'envoi du message à l'administrateur : {$mail->ErrorInfo}");
        }

        // 🔹 Envoi d'un e-mail à l'utilisateur 📩
        try {
            $userMail = new PHPMailer(true);
            $userMail->isSMTP();
            $userMail->Host       = 'smtp.gmail.com';
            $userMail->SMTPAuth   = true;
            $userMail->Username   = 'landryamengne@gmail.com'; // Ton adresse e-mail
            $userMail->Password   = 'nsiz ixfk avcp esnc'; // Mot de passe d'application Gmail
            $userMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $userMail->Port       = 587;

            // 🔹 Paramètres d'expéditeur et destinataire (utilisateur)
            $userMail->setFrom('landryamengne@gmail.com', 'Equipe Formation');
            $userMail->addAddress($email); // Envoi à l'utilisateur

            // 🔹 Contenu du message
            $userMail->isHTML(true);
            $userMail->Subject = 'Confirmation de votre inscription';
            $userMail->Body    = "<h3>Bienvenue $prenom $nom !</h3>
                                  <p>Merci de vous être inscrit à notre programme <strong>$programme</strong> au centre <strong>$centre</strong>.</p>
                                  <p>Nous vous enverrons prochainement plus de détails sur la formation.</p>
                                  <p>Si vous avez des questions, contactez-nous !</p>
                                  <p>Cordialement,</p>
                                  <p><strong>L'équipe de formation</strong></p>";

            $userMail->send();

        } catch (Exception $e) {
            error_log("Erreur d'envoi du message à l'utilisateur : {$userMail->ErrorInfo}");
        }

        // 🔹 Retourne une réponse JSON avec l'URL de redirection
        echo json_encode(["success" => true, "message" => "Inscription réussie !", "redirect" => "confirmation.php"]);
       
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'insertion des données."]);
    }

    $stmt->close();
    $conn->close();
}
?>










