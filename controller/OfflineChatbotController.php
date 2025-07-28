<?php
require_once __DIR__ . '/../model/OfflineChatbotModel.php';

class OfflineChatbotController {
  public function index() {
    require __DIR__ . '/../view/chatbot/index.php';
  }

  public function handle() {
    $message = $_POST['message'] ?? '';
    echo OfflineChatbotModel::reply($message);
  }
}
