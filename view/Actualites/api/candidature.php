

<?php
header("Content-Type: application/json");

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "rapcefop");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Erreur de connexion à la base de données."]);
    exit();
}

// Traitement des données
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $pays = htmlspecialchars($_POST['pays']);

   


       // 🔹 Enregistrement du CV
    $cv_dir = "../uploads/candidature/";
 
    if (!is_dir($cv_dir)) {
        mkdir($cv_dir, 0777, true);
    }

    $cv_file = $cv_dir . basename($_FILES["cv"]["name"]);
    if (move_uploaded_file($_FILES["cv"]["tmp_name"], $cv_file)) {
        $cv_path = $cv_file;

        // 🔹 Enregistrement en base de données
        $stmt = $conn->prepare("INSERT INTO candidatures (nom, email, cv, date_submission, pays) VALUES (?, ?, ?, NOW(), ?)");
        $stmt->bind_param("ssss", $nom, $email, $cv_path, $pays);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["message" => "Candidature envoyée avec succès !"]);

            // 🔹 Envoi de l’e-mail à l’administrateur
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
                $mailAdmin->Subject = "Nouvelle candidature";
                $mailAdmin->Body = "<h3>Un candidat a postulé !</h3>
                                    <p><strong>Nom :</strong> $nom</p>
                                    <p><strong>Email :</strong> $email</p>
                                    <p><strong>Pays :</strong> $pays</p>";

                // 🔹 Attacher le CV
                $mailAdmin->addAttachment($cv_path);

                $mailAdmin->send();
            } catch (Exception $e) {
                error_log("Erreur d'envoi à l'administrateur : {$mailAdmin->ErrorInfo}");
            }

            // 🔹 Envoi de l’e-mail au candidat
            try {
                $mailUser = new PHPMailer(true);
                $mailUser->isSMTP();
                $mailUser->Host = 'smtp.gmail.com';
                $mailUser->SMTPAuth = true;
                $mailUser->Username = 'landryamengne@gmail.com';
                $mailUser->Password = 'nsiz ixfk avcp esnc';
                $mailUser->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mailUser->Port = 587;

                $mailUser->setFrom('landryamengne@gmail.com', 'Plateforme Emploi');
                $mailUser->addAddress($email);

                $mailUser->isHTML(true);
                $mailUser->Subject = "Confirmation de votre candidature";
                $mailUser->Body = "<h3>Merci $nom d’avoir postulé !</h3>
                                   <p>Nous avons bien reçu votre candidature.</p>
                                   <p>Notre équipe examinera votre dossier et vous contactera si vous êtes sélectionné.</p>
                                   <p>Bonne chance !</p>";

                $mailUser->send();
            } catch (Exception $e) {
                error_log("Erreur d'envoi au candidat : {$mailUser->ErrorInfo}");
            }

        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erreur lors de l'enregistrement dans la base de données."]);
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Erreur lors de l'upload du fichier CV."]);
    }
}

$conn->close();
?>
