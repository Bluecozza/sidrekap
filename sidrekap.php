<?php
/**
 * Plugin Name: SidRekap
 * Plugin URI:  https://example.com
 * Description: Plugin untuk mengelola rekap angkutan dengan sistem modular.
 * Version:     1.0
 * Author:      Nama Anda
 * License:     GPL v2 or later
 */

if (!defined('ABSPATH')) {
    exit; // Mencegah akses langsung ke file
}
// 1️⃣ Load File yang Diperlukan
include_once plugin_dir_path(__FILE__) . 'includes/database.php';
include_once plugin_dir_path(__FILE__) . 'includes/admin.php';
include_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// 2️⃣ Fungsi Saat Plugin Diaktifkan
function sidrekap_activate() {
    sidrekap_create_table(); // Buat tabel database
	sidrekap_create_modules_table();
}
register_activation_hook(__FILE__, 'sidrekap_activate');

// 3️⃣ Fungsi Saat Plugin Dinonaktifkan
function sidrekap_deactivate() {
    // Tambahkan jika perlu membersihkan data
}
register_deactivation_hook(__FILE__, 'sidrekap_deactivate');

// 4️⃣ Load Modul Secara Otomatis
function sidrekap_load_modules() {
    $modules_dir = plugin_dir_path(__FILE__) . 'modules/';
    
    if (is_dir($modules_dir)) {
        $modules = scandir($modules_dir);
        foreach ($modules as $module) {
            if ($module !== '.' && $module !== '..') {
                $module_path = $modules_dir . $module . '/' . $module . '.php';
                if (file_exists($module_path)) {
                    include_once $module_path;
                }
            }
        }
    }
}
add_action('plugins_loaded', 'sidrekap_load_modules');


function sidrekap_create_modules_table() {
	global $wpdb;
	define('SIDREKAP_MODULES_TABLE', $wpdb->prefix . 'sidrekap_modules');
    $table_name = SIDREKAP_MODULES_TABLE;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        module_name VARCHAR(255) NOT NULL,
        is_active BOOLEAN DEFAULT 0
    ) $charset_collate;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

