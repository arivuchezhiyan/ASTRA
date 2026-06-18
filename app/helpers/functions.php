<?php
/**
 * Helper Functions
 * Security, data retrieval, upload, and utility functions
 */

// ============================================================
// SECURITY FUNCTIONS
// ============================================================

/**
 * Sanitize input string
 */
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF token
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Output CSRF hidden input field
 */
function csrf_field() {
    echo '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

/**
 * Verify CSRF token
 */
function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Redirect to URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Check if admin is logged in
 */
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Require admin login
 */
function require_admin_login() {
    if (!is_admin_logged_in()) {
        redirect(BASE_URL . '/user-admin.php');
    }
}

/**
 * Set flash message
 */
function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Get and clear flash message
 */
function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// ============================================================
// DATA RETRIEVAL FUNCTIONS
// ============================================================

/**
 * Get all active services
 */
function get_services($pdo, $status = 1) {
    $sql = "SELECT * FROM services WHERE status = ? ORDER BY id ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$status]);
    return $stmt->fetchAll();
}

/**
 * Get service by slug
 */
function get_service_by_slug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ? AND status = 1");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

/**
 * Get service gallery images
 */
function get_service_gallery($pdo, $service_id) {
    $stmt = $pdo->prepare("SELECT * FROM service_gallery WHERE service_id = ? AND status = 1 ORDER BY id ASC");
    $stmt->execute([$service_id]);
    return $stmt->fetchAll();
}

/**
 * Get blogs with pagination
 */
function get_blogs($pdo, $page = 1, $per_page = null) {
    $per_page = $per_page ?? ITEMS_PER_PAGE;
    $offset = ($page - 1) * $per_page;
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE status = 1 ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$per_page, $offset]);
    return $stmt->fetchAll();
}

/**
 * Get total blog count
 */
function get_blog_count($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM blogs WHERE status = 1");
    return $stmt->fetchColumn();
}

/**
 * Get blog by slug
 */
function get_blog_by_slug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE slug = ? AND status = 1");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

/**
 * Get gallery images with pagination
 */
function get_gallery($pdo, $page = 1, $per_page = null, $category = null) {
    $per_page = $per_page ?? ITEMS_PER_PAGE;
    $offset = ($page - 1) * $per_page;
    
    if ($category) {
        $stmt = $pdo->prepare("SELECT * FROM gallery WHERE status = 1 AND category = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$category, $per_page, $offset]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM gallery WHERE status = 1 ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$per_page, $offset]);
    }
    return $stmt->fetchAll();
}

/**
 * Get gallery categories
 */
function get_gallery_categories($pdo) {
    $stmt = $pdo->query("SELECT DISTINCT category FROM gallery WHERE status = 1 AND category IS NOT NULL AND category != '' ORDER BY category ASC");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * Get total gallery count
 */
function get_gallery_count($pdo, $category = null) {
    if ($category) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM gallery WHERE status = 1 AND category = ?");
        $stmt->execute([$category]);
    } else {
        $stmt = $pdo->query("SELECT COUNT(*) FROM gallery WHERE status = 1");
    }
    return $stmt->fetchColumn();
}

/**
 * Get active branches
 */
function get_branches($pdo) {
    $stmt = $pdo->query("SELECT * FROM branches WHERE status = 1 ORDER BY id ASC");
    return $stmt->fetchAll();
}

/**
 * Get enquiries with pagination
 */
function get_enquiries($pdo, $page = 1, $per_page = 20) {
    $offset = ($page - 1) * $per_page;
    $stmt = $pdo->prepare("SELECT * FROM enquiries ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$per_page, $offset]);
    return $stmt->fetchAll();
}

/**
 * Get total enquiry count
 */
function get_enquiry_count($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM enquiries");
    return $stmt->fetchColumn();
}

/**
 * Get hero banners
 */
function get_hero_banners($pdo) {
    $stmt = $pdo->query("SELECT * FROM hero_banners WHERE status = 1 ORDER BY sort_order ASC");
    return $stmt->fetchAll();
}

/**
 * Get site setting
 */
function get_setting($pdo, $key, $default = '') {
    $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $result = $stmt->fetchColumn();
    return $result !== false ? $result : $default;
}

// ============================================================
// ADMIN COUNT FUNCTIONS (for dashboard)
// ============================================================

function count_total($pdo, $table) {
    $allowed = ['services', 'blogs', 'gallery', 'branches', 'enquiries', 'hero_banners'];
    if (!in_array($table, $allowed)) return 0;
    $stmt = $pdo->query("SELECT COUNT(*) FROM `$table`");
    return $stmt->fetchColumn();
}

// ============================================================
// UPLOAD FUNCTIONS
// ============================================================

/**
 * Upload an image file
 * Returns filename on success, false on failure
 */
function upload_image($file, $destination_folder) {
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload error occurred.'];
    }

    // Check file size
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return ['success' => false, 'error' => 'File size exceeds 10MB limit.'];
    }

    // Get file extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXTENSIONS)) {
        return ['success' => false, 'error' => 'Invalid file type. Allowed: jpg, jpeg, png, webp.'];
    }

    // Verify MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!in_array($mime, ALLOWED_MIME_TYPES)) {
        return ['success' => false, 'error' => 'Invalid file MIME type.'];
    }

    // Generate unique filename
    $filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
    $dest_path = UPLOAD_DIR . '/' . $destination_folder;

    // Create directory if not exists
    if (!is_dir($dest_path)) {
        mkdir($dest_path, 0755, true);
    }

    $full_path = $dest_path . '/' . $filename;

    // Check for duplicates via hash
    $file_hash = md5_file($file['tmp_name']);
    $existing_files = glob($dest_path . '/*');
    foreach ($existing_files as $existing) {
        if (is_file($existing) && md5_file($existing) === $file_hash) {
            return ['success' => true, 'filename' => basename($existing), 'message' => 'File already exists.'];
        }
    }

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $full_path)) {
        return ['success' => true, 'filename' => $filename];
    }

    return ['success' => false, 'error' => 'Failed to move uploaded file.'];
}

/**
 * Delete uploaded image
 */
function delete_image($folder, $filename) {
    $path = UPLOAD_DIR . '/' . $folder . '/' . $filename;
    if (file_exists($path)) {
        return unlink($path);
    }
    return false;
}

// ============================================================
// UTILITY FUNCTIONS
// ============================================================

/**
 * Generate URL slug from string
 */
function generate_slug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

/**
 * Truncate text to specified length
 */
function truncate($text, $length = 150) {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}

/**
 * Format date
 */
function format_date($date, $format = 'j M Y') {
    return date($format, strtotime($date));
}

/**
 * Get upload URL for display
 */
function upload_url($folder, $filename) {
    return UPLOAD_URL . '/' . $folder . '/' . $filename;
}

/**
 * Generate pagination HTML (Missio template style)
 */
function render_pagination($current_page, $total_pages, $base_url) {
    if ($total_pages <= 1) return '';
    
    $html = '<div class="pagination bg text-center"><ul>';
    
    // Previous
    if ($current_page > 1) {
        $html .= '<li><a href="' . $base_url . '?page=' . ($current_page - 1) . '" class="btn btn-white shadow"><i class="mi-arrow-left"></i></a></li>';
    }
    
    // Page numbers
    for ($i = 1; $i <= $total_pages; $i++) {
        $active = ($i == $current_page) ? ' class="active"' : '';
        $html .= '<li' . $active . '><a href="' . $base_url . '?page=' . $i . '" class="btn btn-white shadow"><span>' . $i . '</span></a></li>';
    }
    
    // Next
    if ($current_page < $total_pages) {
        $html .= '<li><a href="' . $base_url . '?page=' . ($current_page + 1) . '" class="btn btn-white shadow"><i class="mi-arrow-right"></i></a></li>';
    }
    
    $html .= '</ul></div>';
    return $html;
}
