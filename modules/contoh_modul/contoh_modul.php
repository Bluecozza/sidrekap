<?php
/**
 * Modul Contoh - Hanya untuk demo
 */

if (!defined('ABSPATH')) {
    exit;
}

// Fungsi Modul
function contoh_modul_hello() {
    echo "<p>Halo, ini modul contoh!</p>";
}
add_action('admin_notices', 'contoh_modul_hello');
