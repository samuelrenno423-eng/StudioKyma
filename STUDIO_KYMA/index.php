<?php
declare(strict_types=1);

// Sicurezza cookie sessione
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,      // HTTPS
    'httponly' => true,    // blocca JavaScript
    'samesite' => 'Strict'
]);



session_start();

// Header di sicurezza
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin");
header("Content-Security-Policy: default-src 'self'; style-src 'self' https://cdn.jsdelivr.net; script-src 'self' https://cdn.jsdelivr.net;");

// Connessione PDO sicura
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=studio_kyma;charset=utf8mb4",
        "utente",
        "password_molto_forte",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch(PDOException $e) {
    die("Errore di connessione");
}

// Funzione per pulire l'output
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
