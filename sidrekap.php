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
define('SIDREKAP_CRUD_TABLE', $wpdb->prefix . 'sidrekap');
// 1️⃣ Load File yang Diperlukan
include_once plugin_dir_path(__FILE__) . 'includes/database.php';
include_once plugin_dir_path(__FILE__) . 'includes/admin.php';
include_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// 2️⃣ Fungsi Saat Plugin Diaktifkan
function sidrekap_activate() {
    sidrekap_create_table(); // Buat tabel database
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
