<?php
global $wpdb;
//define('SIDREKAP_CRUD_TABLE', $wpdb->prefix . 'sidrekap');
function sidrekap_create_table() {
    global $wpdb;
    $table_name = SIDREKAP_CRUD_TABLE;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        tanggal DATE NOT NULL,
        asal VARCHAR(255) NOT NULL,
        tujuan VARCHAR(255) NOT NULL,
        kode VARCHAR(50) NOT NULL,
        retase FLOAT NOT NULL,
        jenis_angkutan VARCHAR(255) NOT NULL,
        armada VARCHAR(255) NOT NULL,
        tiket VARCHAR(255) NOT NULL,
        keterangan TEXT NULL
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
