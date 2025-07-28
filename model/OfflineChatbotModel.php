<?php
class OfflineChatbotModel {
  public static function reply($message) {
    $intents = include __DIR__ . '/../config/responses.php';
    $msg = strtolower(trim($message));

    foreach ($intents as $keyword => $response) {
      if (strpos($msg, $keyword) !== false) {
        return $response;
      }
    }

    return "Je suis désolé, je ne comprends pas encore cette demande. Essayez avec 'inscription', 'centre' ou 'actualités'.";
  }
}
