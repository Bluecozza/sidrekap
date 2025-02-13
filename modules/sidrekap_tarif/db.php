<?php
global $wpdb;
define('SIDREKAP_TARIF_TABLE', $wpdb->prefix . 'sidrekap_tarif');

function sidrekap_tarif_create_table() {
    global $wpdb;
    $table_name = SIDREKAP_TARIF_TABLE;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        asal VARCHAR(255) NOT NULL,
        tujuan VARCHAR(255) NOT NULL,
        armada VARCHAR(255) NOT NULL,
        jenis_angkutan VARCHAR(255) NOT NULL,
        tarif FLOAT NOT NULL
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

// Jalankan saat plugin diaktifkan
register_activation_hook(__FILE__, 'sidrekap_tarif_create_table');
?>
