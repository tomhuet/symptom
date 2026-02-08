<?php
// Security: Start session with secure parameters
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
    ini_set('session.cookie_samesite', 'Strict');
    ini_set('session.use_strict_mode', 1);
    session_start();
}

// Security: Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

define('SITE_NAME', 'SYMPTOM');
define('SITE_URL', 'https://www.symptom.agency');
define('ADMIN_USERNAME', 'admin');
// TODO: Use environment variables for sensitive data
define('ADMIN_PASSWORD', password_hash('symptom2025', PASSWORD_DEFAULT));
define('DATA_DIR', __DIR__ . '/data/');
define('UPLOADS_DIR', __DIR__ . '/uploads/');
define('PROJECTS_FILE', DATA_DIR . 'projects.json');
define('REVIEWS_FILE', DATA_DIR . 'reviews.json');

// Security: Ensure directories are protected
if (!is_dir(DATA_DIR)) {
    mkdir(DATA_DIR, 0755, true);
    file_put_contents(DATA_DIR . '.htaccess', 'Deny from all');
}
if (!is_dir(UPLOADS_DIR)) {
    mkdir(UPLOADS_DIR, 0755, true);
}
if (!file_exists(PROJECTS_FILE)) {
    file_put_contents(PROJECTS_FILE, json_encode([]));
}
if (!file_exists(REVIEWS_FILE)) {
    file_put_contents(REVIEWS_FILE, json_encode([]));
}

// Simple file-based caching
function getFromCache($key, $maxAge = 3600) {
    $cacheFile = DATA_DIR . 'cache_' . md5($key) . '.json';
    if (file_exists($cacheFile)) {
        $cacheData = json_decode(file_get_contents($cacheFile), true);
        if ($cacheData && (time() - $cacheData['timestamp']) < $maxAge) {
            return $cacheData['data'];
        }
    }
    return null;
}

function setCache($key, $data) {
    $cacheFile = DATA_DIR . 'cache_' . md5($key) . '.json';
    file_put_contents($cacheFile, json_encode([
        'timestamp' => time(),
        'data' => $data
    ]));
}

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function getProjects() {
    $cached = getFromCache('projects', 300); // Cache for 5 minutes
    if ($cached !== null) {
        return $cached;
    }
    
    $projects = json_decode(file_get_contents(PROJECTS_FILE), true) ?: [];
    setCache('projects', $projects);
    return $projects;
}

function getProject($idOrSlug) {
    // Security: Sanitize input
    $idOrSlug = preg_replace('/[^a-zA-Z0-9-_]/', '', $idOrSlug);
    
    foreach (getProjects() as $project) {
        if ($project['id'] === $idOrSlug || $project['slug'] === $idOrSlug) return $project;
    }
    return null;
}

function saveProjects($projects) {
    file_put_contents(PROJECTS_FILE, json_encode($projects, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    // Clear cache after save
    $cacheFile = DATA_DIR . 'cache_' . md5('projects') . '.json';
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
    }
}

function getReviews() {
    $cached = getFromCache('reviews', 300); // Cache for 5 minutes
    if ($cached !== null) {
        return $cached;
    }
    
    $reviews = json_decode(file_get_contents(REVIEWS_FILE), true) ?: [];
    setCache('reviews', $reviews);
    return $reviews;
}

function getReviewsByProject($projectId) {
    return array_filter(getReviews(), fn($r) => isset($r['project_id']) && $r['project_id'] === $projectId);
}

function saveReviews($reviews) {
    file_put_contents(REVIEWS_FILE, json_encode($reviews, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    // Clear cache after save
    $cacheFile = DATA_DIR . 'cache_' . md5('reviews') . '.json';
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
    }
}

function generateSlug($string) {
    // Improved slug generation with better transliteration
    $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    return trim($string, '-');
}

function generateId() {
    return uniqid('', true) . '-' . bin2hex(random_bytes(4));
}

function uploadImage($file) {
    // Security: Validate file upload
    $allowed = ['image/jpeg', 'image/png', 'image/webp'];
    
    if (!isset($file['error']) || is_array($file['error'])) {
        return false;
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    if ($file['size'] > 5242880) { // Max 5MB
        return false;
    }
    
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    
    if (!in_array($mimeType, $allowed)) {
        return false;
    }
    
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = generateId() . '.' . $ext;
    
    if (move_uploaded_file($file['tmp_name'], UPLOADS_DIR . $filename)) {
        return 'uploads/' . $filename;
    }
    return false;
}

// Security: Function to sanitize output
function escape($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// Security: CSRF token validation
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Get CSRF token for forms
function getCSRFToken() {
    return $_SESSION['csrf_token'] ?? '';
}
?>
