<?php
function sidrekap_tarif_admin_page() {
    global $wpdb;
    $table_name = SIDREKAP_TARIF_TABLE;

    // Menangani insert atau update tarif
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        $data = [
            'asal' => sanitize_text_field($_POST['asal']),
            'tujuan' => sanitize_text_field($_POST['tujuan']),
            'armada' => sanitize_text_field($_POST['armada']),
            'jenis_angkutan' => sanitize_text_field($_POST['jenis_angkutan']),
            'tarif' => floatval($_POST['tarif'])
        ];

        if ($id > 0) {
            $wpdb->update($table_name, $data, ['id' => $id]);
        } else {
            $wpdb->insert($table_name, $data);
        }

        wp_redirect(admin_url('admin.php?page=sidrekap_tarif'));
        exit;
    }

    // Menangani hapus tarif
    if (isset($_GET['delete'])) {
        $wpdb->delete($table_name, ['id' => intval($_GET['delete'])]);
        wp_redirect(admin_url('admin.php?page=sidrekap_tarif'));
        exit;
    }

    // Ambil semua data tarif dari database
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
?>

<div class="wrap">
    <h1>Kelola Tarif Angkutan</h1>

    <button id="openInsertModal">Tambah Tarif</button>

    <!-- Modal Tambah/Edit Tarif -->
    <div id="tarifModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Tambah Tarif</h2>
            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                <input type="hidden" name="id">
                <label>Asal</label><input type="text" name="asal" required>
                <label>Tujuan</label><input type="text" name="tujuan" required>
                <label>Armada</label><input type="text" name="armada" required>
                <label>Jenis Angkutan</label><input type="text" name="jenis_angkutan" required>
                <label>Tarif</label><input type="number" step="100" name="tarif" required>
                <button type="submit" name="submit">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Tabel Tarif -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Armada</th>
                <th>Jenis Angkutan</th>
                <th>Tarif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row) : ?>
                <tr>
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->asal; ?></td>
                    <td><?php echo $row->tujuan; ?></td>
                    <td><?php echo $row->armada; ?></td>
                    <td><?php echo $row->jenis_angkutan; ?></td>
                    <td><?php echo number_format($row->tarif, 0, ',', '.'); ?></td>
                    <td>
                        <button class="edit-btn" 
                            data-id="<?php echo $row->id; ?>"
                            data-asal="<?php echo $row->asal; ?>"
                            data-tujuan="<?php echo $row->tujuan; ?>"
                            data-armada="<?php echo $row->armada; ?>"
                            data-jenis_angkutan="<?php echo $row->jenis_angkutan; ?>"
                            data-tarif="<?php echo $row->tarif; ?>">
                            Edit
                        </button>
                        <a href="?page=sidrekap_tarif&delete=<?php echo $row->id; ?>" 
                           onclick="return confirm('Yakin ingin menghapus tarif ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let modal = document.getElementById("tarifModal");
    let form = modal.querySelector("form");

    // Buka modal tambah data
    document.getElementById("openInsertModal").addEventListener("click", function() {
        form.id.value = "";
        form.asal.value = "";
        form.tujuan.value = "";
        form.armada.value = "";
        form.jenis_angkutan.value = "";
        form.tarif.value = "";
        document.getElementById("modalTitle").textContent = "Tambah Tarif";
        modal.style.display = "block";
    });

    // Buka modal edit data
    document.querySelectorAll(".edit-btn").forEach(function(btn) {
        btn.addEventListener("click", function() {
            form.id.value = this.dataset.id;
            form.asal.value = this.dataset.asal;
            form.tujuan.value = this.dataset.tujuan;
            form.armada.value = this.dataset.armada;
            form.jenis_angkutan.value = this.dataset.jenis_angkutan;
            form.tarif.value = this.dataset.tarif;
            document.getElementById("modalTitle").textContent = "Edit Tarif";
            modal.style.display = "block";
        });
    });

    // Tutup modal
    document.querySelector(".close").addEventListener("click", function() {
        modal.style.display = "none";
    });
});
</script>

<?php
} // Menutup function sidrekap_tarif_admin_page
?>
