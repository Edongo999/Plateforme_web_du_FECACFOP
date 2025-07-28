<?php
require_once __DIR__ . '/../controller/OfflineChatbotController.php';
$bot = new OfflineChatbotController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bot->handle();
} else {
  $bot->index();
}
