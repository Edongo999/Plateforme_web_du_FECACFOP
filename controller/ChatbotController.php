<?php
require_once __DIR__ . '/../model/ChatbotModel.php';

class ChatbotController {
  public function index() {
    include __DIR__ . '/../view/chatbot/index.php';
  }

  public function reply() {
    $msg = $_POST['message'] ?? '';
    echo ChatbotModel::ask($msg);
  }
}
