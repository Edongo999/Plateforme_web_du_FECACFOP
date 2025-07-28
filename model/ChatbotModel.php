<?php
class ChatbotModel {
  public static function ask($message, $debug = false) {
    require_once __DIR__ . '/../config/openai.php';

    $data = [
      "model" => "gpt-3.5-turbo",
      "messages" => [
        [
          "role" => "system",
          "content" => "Tu es l'assistant virtuel de la plateforme FECACFOP. Tu aides les utilisateurs à s'inscrire, à consulter les centres de formation, à explorer les actualités, et à comprendre comment utiliser les services du site. Tes réponses sont claires, concises et conviviales."
        ],
        [
          "role" => "user",
          "content" => $message
        ]
      ]
    ];

    // Appel API
    $curl = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt_array($curl, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . OPENAI_API_KEY
      ],
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => json_encode($data),
      CURLOPT_SSL_VERIFYPEER => false // ✅ désactivation temporaire pour test local
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    curl_close($curl);

    // Gestion des erreurs
    if ($response === false || $httpCode >= 400) {
      return "Erreur de connexion à ChatGPT (code $httpCode). Détail : $curlError";
    }

    $result = json_decode($response, true);

    // Mode debug (facultatif)
    if ($debug) {
      echo "<pre>";
      print_r($result);
      echo "</pre>";
      exit;
    }

    // Retour propre
    return $result['choices'][0]['message']['content'] ?? "❌ Réponse non reconnue.";
  }
}
