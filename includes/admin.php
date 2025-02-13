<?php
    global $wpdb;
	define('SIDREKAP_MODULES_TABLE', $wpdb->prefix . 'sidrekap_modules');
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

function sidrekap_add_modules_menu() {
    add_menu_page('Modul SidRekap', 'Modul SidRekap', 'manage_options', 'sidrekap_modules', 'sidrekap_modules_admin_page');
}

add_action('admin_menu', 'sidrekap_add_modules_menu');

////////////

function sidrekap_modules_admin_page() {
    global $wpdb;
	//define('SIDREKAP_MODULES_TABLE', $wpdb->prefix . 'sidrekap_modules');
    $table_name = SIDREKAP_MODULES_TABLE;

    // Menangani aktivasi / deaktivasi modul
    if (isset($_GET['activate']) || isset($_GET['deactivate'])) {
        $module_name = sanitize_text_field($_GET['module_name']);
        if (isset($_GET['activate'])) {
            $wpdb->replace($table_name, ['module_name' => $module_name, 'is_active' => 1], ['module_name']);
        } elseif (isset($_GET['deactivate'])) {
            $wpdb->replace($table_name, ['module_name' => $module_name, 'is_active' => 0], ['module_name']);
        }

        wp_redirect(admin_url('admin.php?page=sidrekap_modules'));
        exit;
    }

    // Ambil semua status modul dari database
    $results = $wpdb->get_results("SELECT * FROM $table_name");

    // Tampilkan halaman admin untuk modul
    ?>
    <div class="wrap">
        <h1>Kelola Modul SidRekap</h1>

        <table>
            <thead>
                <tr>
                    <th>Nama Modul</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $module) : ?>
                    <tr>
                        <td><?php echo esc_html($module->module_name); ?></td>
                        <td><?php echo $module->is_active ? 'Aktif' : 'Tidak Aktif'; ?></td>
                        <td>
                            <?php if ($module->is_active) : ?>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=sidrekap_modules&deactivate=true&module_name=' . $module->module_name)); ?>">Nonaktifkan</a>
                            <?php else : ?>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=sidrekap_modules&activate=true&module_name=' . $module->module_name)); ?>">Aktifkan</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <hr>

        <h2>Aktifkan Modul Baru</h2>
        <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
            <label>Nama Modul</label>
            <input type="text" name="module_name" required>
            <button type="submit" name="add_module">Tambah Modul</button>
        </form>
    </div>
    <?php

    // Menangani penambahan modul baru
    if (isset($_POST['add_module'])) {
        $module_name = sanitize_text_field($_POST['module_name']);
        $wpdb->insert($table_name, ['module_name' => $module_name, 'is_active' => 0]);
        wp_redirect(admin_url('admin.php?page=sidrekap_modules'));
        exit;
    }
}
