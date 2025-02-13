<?php
function sidrekap_admin_menu() {
    add_menu_page(
        'SidRekap', 'SidRekap', 'manage_options', 
        'sidrekap', 'sidrekap_admin_page', 
        'dashicons-analytics', 25
    );
}
add_action('admin_menu', 'sidrekap_admin_menu');

function sidrekap_admin_page() {
    ?>
    <div class="wrap">
        <h1>SidRekap - Rekap Angkutan</h1>
        <p>Selamat datang di SidRekap! Anda dapat mengelola rekap angkutan di sini.</p>
    </div>
    <?php
}
