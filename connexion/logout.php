<?php
session_start();
session_destroy(); // Supprime la session
header("Location: index.html");
exit();
?>
