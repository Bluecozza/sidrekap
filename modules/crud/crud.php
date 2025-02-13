<?php
/**
 * Modul CRUD untuk SidRekap
 */

if (!defined('ABSPATH')) {
    exit;
}

// Pastikan file konfigurasi dimuat
include_once plugin_dir_path(__FILE__) . 'config.php';
include_once plugin_dir_path(__FILE__) . 'admin-crud.php';

// Registrasi menu admin untuk modul CRUD
function sidrekap_crud_admin_menu() {
    add_submenu_page(
        'sidrekap',
        'Kelola Data Angkutan',
        'Data Angkutan',
        'manage_options',
        'sidrekap_crud',
        'sidrekap_crud_admin_page'
    );
}
add_action('admin_menu', 'sidrekap_crud_admin_menu');
