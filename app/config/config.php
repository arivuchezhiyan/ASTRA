<?php
/**
 * Site Configuration
 */

// Load environment variables
require_once __DIR__ . '/env.php';

define('BASE_URL', getenv('BASE_URL') !== false ? getenv('BASE_URL') : '/photo/astroclicks');
define('ASSETS_URL', BASE_URL . '/style');
define('UPLOAD_URL', BASE_URL . '/uploads');
define('UPLOAD_DIR', dirname(dirname(__DIR__)) . '/uploads');
define('SITE_NAME', 'AstraClicks');
define('SITE_TAGLINE', 'Photography & Videography Studio');
define('WHATSAPP_NUMBER', '917200064523');
define('WHATSAPP_URL', 'https://wa.me/' . WHATSAPP_NUMBER);

// Pagination
define('ITEMS_PER_PAGE', 9);

// Upload settings
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);
define('ALLOWED_MIME_TYPES', ['image/jpeg', 'image/png', 'image/webp']);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}
