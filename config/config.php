<?php
return [
    // 🔹 Paramètres SMTP (email)
    'SMTP_USER' => 'landryamengne@gmail.com',  // Ton email SMTP
    'SMTP_PASS' => 'nsiz ixfk avcp esnc',  // Ton mot de passe SMTP sécurisé

    // 🔹 Email de l'administrateur
    'ADMIN_EMAIL' => 'landryamengne@gmail.com', // Email à notifier lors d'une inscription

    // 🔹 Clé secrète pour chiffrement
    'SECRET_KEY' => '52f10deb078f9d7e9637146a81f1d398a0888dfa981e1df2d173065ccb90f1e7', // Clé générée
       // 'IV' => '1234567890123456', // 🔐 Ajout de l’IV ici
       'IV' => substr(bin2hex(random_bytes(8)), 0, 16), // 🔥 IV sécurisé, taille correcte

  

    // 🔹 Paramètres base de données (optionnel si déjà ailleurs)
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PASS' => '',
    'DB_NAME' => 'rapcefop'
];

