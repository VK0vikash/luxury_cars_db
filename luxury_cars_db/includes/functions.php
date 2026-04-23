<?php
// Utility functions for Luxury Auto website

/**
 * Sanitize input data
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validate email address
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Format price with currency symbol
 */
function format_price($price) {
    return '$' . number_format($price, 0);
}

/**
 * Generate SEO-friendly URL slug
 */
function generate_slug($string) {
    $slug = strtolower($string);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

/**
 * Upload file with validation
 */
function upload_file($file, $type = 'image', $max_size = 5242880) {
    $allowed_types = [];
    
    if ($type === 'image') {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $upload_dir = UPLOAD_PATH . 'cars/';
    } elseif ($type === 'pdf') {
        $allowed_types = ['pdf'];
        $upload_dir = UPLOAD_PATH . 'brochures/';
    } elseif ($type === 'video') {
        $allowed_types = ['mp4', 'mov', 'avi'];
        $upload_dir = UPLOAD_PATH . 'videos/';
    }
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_name = basename($file['name']);
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validate file type
    if (!in_array($file_ext, $allowed_types)) {
        return ['error' => 'Invalid file type. Allowed types: ' . implode(', ', $allowed_types)];
    }
    
    // Validate file size
    if ($file_size > $max_size) {
        return ['error' => 'File too large. Maximum size: ' . ($max_size / 1024 / 1024) . 'MB'];
    }
    
    // Generate unique filename
    $unique_name = uniqid() . '_' . time() . '.' . $file_ext;
    $upload_path = $upload_dir . $unique_name;
    
    // Move uploaded file
    if (move_uploaded_file($file_tmp, $upload_path)) {
        return ['success' => true, 'filename' => $unique_name, 'path' => $upload_path];
    } else {
        return ['error' => 'Failed to upload file'];
    }
}

/**
 * Resize image for optimization
 */
function resize_image($source_path, $dest_path, $max_width, $max_height) {
    list($orig_width, $orig_height, $type) = getimagesize($source_path);
    
    // Calculate new dimensions
    $ratio = $orig_width / $orig_height;
    
    if ($max_width / $max_height > $ratio) {
        $new_width = $max_height * $ratio;
        $new_height = $max_height;
    } else {
        $new_width = $max_width;
        $new_height = $max_width / $ratio;
    }
    
    // Create new image
    $new_image = imagecreatetruecolor($new_width, $new_height);
    
    // Load original image based on type
    switch($type) {
        case IMAGETYPE_JPEG:
            $orig_image = imagecreatefromjpeg($source_path);
            break;
        case IMAGETYPE_PNG:
            $orig_image = imagecreatefrompng($source_path);
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            break;
        case IMAGETYPE_GIF:
            $orig_image = imagecreatefromgif($source_path);
            break;
        case IMAGETYPE_WEBP:
            $orig_image = imagecreatefromwebp($source_path);
            break;
        default:
            return false;
    }
    
    // Resize image
    imagecopyresampled($new_image, $orig_image, 0, 0, 0, 0, 
                      $new_width, $new_height, $orig_width, $orig_height);
    
    // Save image
    switch($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($new_image, $dest_path, 85);
            break;
        case IMAGETYPE_PNG:
            imagepng($new_image, $dest_path, 9);
            break;
        case IMAGETYPE_GIF:
            imagegif($new_image, $dest_path);
            break;
        case IMAGETYPE_WEBP:
            imagewebp($new_image, $dest_path, 85);
            break;
    }
    
    // Free memory
    imagedestroy($orig_image);
    imagedestroy($new_image);
    
    return true;
}

/**
 * Send email notification
 */
function send_email_notification($to, $subject, $template, $data) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . SITE_NAME . " <" . ADMIN_EMAIL . ">" . "\r\n";
    
    // Load email template
    $message = file_get_contents('templates/emails/' . $template . '.html');
    
    // Replace template variables
    foreach($data as $key => $value) {
        $message = str_replace('{{' . $key . '}}', $value, $message);
    }
    
    return mail($to, $subject, $message, $headers);
}

/**
 * Get pagination variables
 */
function get_pagination($page, $items_per_page, $total_items) {
    $total_pages = ceil($total_items / $items_per_page);
    $offset = ($page - 1) * $items_per_page;
    
    return [
        'current_page' => $page,
        'items_per_page' => $items_per_page,
        'total_items' => $total_items,
        'total_pages' => $total_pages,
        'offset' => $offset,
        'has_previous' => $page > 1,
        'has_next' => $page < $total_pages
    ];
}

/**
 * Generate pagination links
 */
function generate_pagination($current_page, $total_pages, $base_url) {
    if ($total_pages <= 1) return '';
    
    $html = '<div class="pagination">';
    
    // Previous button
    if ($current_page > 1) {
        $html .= '<a href="' . $base_url . ($current_page - 1) . '" class="page-link prev">&laquo; Previous</a>';
    }
    
    // Page numbers
    $start = max(1, $current_page - 2);
    $end = min($total_pages, $current_page + 2);
    
    if ($start > 1) {
        $html .= '<a href="' . $base_url . '1" class="page-link">1</a>';
        if ($start > 2) $html .= '<span class="page-dots">...</span>';
    }
    
    for ($i = $start; $i <= $end; $i++) {
        $active = $i == $current_page ? ' active' : '';
        $html .= '<a href="' . $base_url . $i . '" class="page-link' . $active . '">' . $i . '</a>';
    }
    
    if ($end < $total_pages) {
        if ($end < $total_pages - 1) $html .= '<span class="page-dots">...</span>';
        $html .= '<a href="' . $base_url . $total_pages . '" class="page-link">' . $total_pages . '</a>';
    }
    
    // Next button
    if ($current_page < $total_pages) {
        $html .= '<a href="' . $base_url . ($current_page + 1) . '" class="page-link next">Next &raquo;</a>';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Generate random string
 */
function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';
    
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $random_string;
}

/**
 * Log activity
 */
function log_activity($user_id, $action, $details = '') {
    global $conn;
    
    $stmt = $conn->prepare("
        INSERT INTO activity_logs (user_id, action, details, ip_address, user_agent) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $user_id,
        $action,
        $details,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    ]);
}

/**
 * Get recent activity
 */
function get_recent_activity($limit = 10) {
    global $conn;
    
    $stmt = $conn->prepare("
        SELECT al.*, a.username 
        FROM activity_logs al 
        LEFT JOIN admins a ON al.user_id = a.id 
        ORDER BY al.created_at DESC 
        LIMIT ?
    ");
    
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

/**
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get client IP address
 */
function get_client_ip() {
    $ipaddress = '';
    
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    
    return $ipaddress;
}

/**
 * Truncate text with ellipsis
 */
function truncate_text($text, $length = 100) {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $truncated = substr($text, 0, $length);
    $truncated = substr($truncated, 0, strrpos($truncated, ' '));
    
    return $truncated . '...';
}

/**
 * Format date in human-readable format
 */
function human_date($date) {
    $now = new DateTime();
    $date_obj = new DateTime($date);
    $interval = $now->diff($date_obj);
    
    if ($interval->y > 0) {
        return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
    } elseif ($interval->m > 0) {
        return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
    } elseif ($interval->d > 0) {
        return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
    } elseif ($interval->h > 0) {
        return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
    } elseif ($interval->i > 0) {
        return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
    } else {
        return 'Just now';
    }
}

/**
 * Get setting value
 */
function get_setting($key) {
    global $conn;
    
    static $settings = [];
    
    if (empty($settings)) {
        $stmt = $conn->query("SELECT setting_key, setting_value FROM settings");
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
    
    return $settings[$key] ?? null;
}

/**
 * Update setting value
 */
function update_setting($key, $value) {
    global $conn;
    
    $stmt = $conn->prepare("
        INSERT INTO settings (setting_key, setting_value) 
        VALUES (?, ?) 
        ON DUPLICATE KEY UPDATE setting_value = ?
    ");
    
    return $stmt->execute([$key, $value, $value]);
}
?>