<?php
session_start();

define('SITE_NAME', 'SYMPTOM');
define('SITE_URL', 'https://www.symptom.agency');
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'symptom2025');
define('DATA_DIR', __DIR__ . '/data/');
define('UPLOADS_DIR', __DIR__ . '/uploads/');
define('PROJECTS_FILE', DATA_DIR . 'projects.json');
define('REVIEWS_FILE', DATA_DIR . 'reviews.json');

if (!is_dir(DATA_DIR)) mkdir(DATA_DIR, 0755, true);
if (!is_dir(UPLOADS_DIR)) mkdir(UPLOADS_DIR, 0755, true);
if (!file_exists(PROJECTS_FILE)) file_put_contents(PROJECTS_FILE, json_encode([]));
if (!file_exists(REVIEWS_FILE)) file_put_contents(REVIEWS_FILE, json_encode([]));

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function getProjects() {
    return json_decode(file_get_contents(PROJECTS_FILE), true) ?: [];
}

function getProject($idOrSlug) {
    foreach (getProjects() as $project) {
        if ($project['id'] === $idOrSlug || $project['slug'] === $idOrSlug) return $project;
    }
    return null;
}

function saveProjects($projects) {
    file_put_contents(PROJECTS_FILE, json_encode($projects, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getReviews() {
    return json_decode(file_get_contents(REVIEWS_FILE), true) ?: [];
}

function getReviewsByProject($projectId) {
    return array_filter(getReviews(), fn($r) => isset($r['project_id']) && $r['project_id'] === $projectId);
}

function saveReviews($reviews) {
    file_put_contents(REVIEWS_FILE, json_encode($reviews, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function generateSlug($string) {
    $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    return trim($string, '-');
}

function generateId() {
    return uniqid() . '-' . bin2hex(random_bytes(4));
}

function uploadImage($file) {
    $allowed = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($file['type'], $allowed)) return false;
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = generateId() . '.' . $ext;
    if (move_uploaded_file($file['tmp_name'], UPLOADS_DIR . $filename)) {
        return 'uploads/' . $filename;
    }
    return false;
}
?>
