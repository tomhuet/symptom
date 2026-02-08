<?php
require_once 'config.php';

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Security: CSRF token validation
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!validateCSRFToken($csrfToken)) {
        http_response_code(403);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode(['success' => false, 'error' => 'Invalid security token']);
            exit;
        }
        header('Location: /?error=csrf');
        exit;
    }
    
    // Security: Input sanitization
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 
                    filter_input(INPUT_POST, 'project', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
    
    // Validation
    $errors = [];
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email invalide';
    }
    if (empty($message) || strlen($message) < 10) {
        $errors[] = 'Message trop court';
    }
    
    if (empty($errors)) {
        // Prepare email content
        $to = 'hello@symptom.agency';
        $subject = 'Nouveau message de ' . ($name ?: 'Visiteur');
        $body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: noreply@symptom.agency\r\nReply-To: $email\r\n";
        
        // Send email (note: mail() might not work in all environments)
        @mail($to, $subject, $body, $headers);
        
        // Save to file as backup
        $logDir = DATA_DIR . 'contacts/';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $logFile = $logDir . date('Y-m-d') . '.json';
        $contacts = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
        $contacts[] = [
            'timestamp' => date('Y-m-d H:i:s'),
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ];
        file_put_contents($logFile, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo json_encode([
            'success' => empty($errors),
            'errors' => $errors
        ]);
        exit;
    }
    
    if (empty($errors)) {
        header('Location: /?sent=1#contact');
    } else {
        header('Location: /?error=validation#contact');
    }
    exit;
}

header('Location: /');
exit;
