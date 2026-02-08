<?php
/**
 * Simple health check endpoint
 * Used for monitoring and uptime checks
 * Returns JSON with status information
 */

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

$status = 'ok';
$checks = [];

// Check PHP version
$checks['php_version'] = [
    'status' => version_compare(PHP_VERSION, '7.4.0', '>=') ? 'ok' : 'warning',
    'value' => PHP_VERSION
];

// Check data directory
$checks['data_directory'] = [
    'status' => is_dir(__DIR__ . '/data') && is_writable(__DIR__ . '/data') ? 'ok' : 'error',
    'writable' => is_writable(__DIR__ . '/data')
];

// Check uploads directory
$checks['uploads_directory'] = [
    'status' => is_dir(__DIR__ . '/uploads') && is_writable(__DIR__ . '/uploads') ? 'ok' : 'error',
    'writable' => is_writable(__DIR__ . '/uploads')
];

// Check required PHP extensions
$required_extensions = ['json', 'fileinfo', 'mbstring'];
$missing_extensions = [];
foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

$checks['php_extensions'] = [
    'status' => empty($missing_extensions) ? 'ok' : 'error',
    'missing' => $missing_extensions
];

// Overall status
foreach ($checks as $check) {
    if ($check['status'] === 'error') {
        $status = 'error';
        break;
    } elseif ($check['status'] === 'warning' && $status === 'ok') {
        $status = 'warning';
    }
}

$response = [
    'status' => $status,
    'timestamp' => date('c'),
    'checks' => $checks
];

http_response_code($status === 'ok' ? 200 : ($status === 'warning' ? 200 : 503));
echo json_encode($response, JSON_PRETTY_PRINT);
