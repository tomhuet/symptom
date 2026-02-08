<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? $_POST['project'] ?? '');
    
    if (!empty($email) && !empty($message)) {
        $to = 'hello@symptom.agency';
        $subject = 'Nouveau message de ' . ($name ?: 'Visiteur');
        $body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email\r\nReply-To: $email\r\n";
        
        mail($to, $subject, $body, $headers);
    }
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo json_encode(['success' => true]);
        exit;
    }
    
    header('Location: /?sent=1#contact');
    exit;
}

header('Location: /');
exit;
