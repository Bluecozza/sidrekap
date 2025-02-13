<?php
function sidrekap_crud_admin_page() {
    global $wpdb;
    $table_name = SIDREKAP_CRUD_TABLE;


// Menangani insert atau update data
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        $data = [
            'tanggal' => sanitize_text_field($_POST['tanggal']),
            'asal' => sanitize_text_field($_POST['asal']),
            'tujuan' => sanitize_text_field($_POST['tujuan']),
            'kode' => sanitize_text_field($_POST['kode']),
            'retase' => floatval($_POST['retase']),
            'jenis_angkutan' => sanitize_text_field($_POST['jenis_angkutan']),
            'armada' => sanitize_text_field($_POST['armada']),
            'tiket' => sanitize_text_field($_POST['tiket']),
            'keterangan' => sanitize_textarea_field($_POST['keterangan'])
        ];

        if ($id > 0) {
            $updated = $wpdb->update($table_name, $data, ['id' => $id]);
            if ($updated === false) {
                echo "<script>alert('Gagal memperbarui data! Error: " . esc_js($wpdb->last_error) . "');</script>";
            }
        } else {
            $inserted = $wpdb->insert($table_name, $data);
            if ($inserted === false) {
                echo "<script>alert('Gagal menambahkan data! Error: " . esc_js($wpdb->last_error) . "');</script>";
            }
        }

        wp_redirect(admin_url('admin.php?page=sidrekap_crud'));
        exit;
    }
////////////////
    // Menangani penghapusan data
    if (isset($_GET['delete'])) {
        $wpdb->delete($table_name, ['id' => intval($_GET['delete'])]);
        wp_redirect(admin_url('admin.php?page=sidrekap_crud'));
        exit;
    }

    // Ambil semua data
    $data = $wpdb->get_results("SELECT * FROM $table_name");
	    // Ambil semua data dari database
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");

    ?>

<div class="wrap">
    <h1>Kelola Data Angkutan</h1>

    <!-- Tombol Tambah Data -->
    <button id="openInsertModal">Tambah Data</button>

    <!-- Modal Tambah Data -->
    <div id="insertModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tambah Data</h2>
            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                <input type="hidden" name="id">
                <label>Tanggal</label><input type="date" name="tanggal" required>
                <label>Asal</label><input type="text" name="asal" required>
                <label>Tujuan</label><input type="text" name="tujuan" required>
                <label>Kode</label><input type="text" name="kode" required>
                <label>Retase</label><input type="number" step="0.1" name="retase" required>
                <label>Jenis Angkutan</label><input type="text" name="jenis_angkutan" required>
                <label>Armada</label><input type="text" name="armada" required>
                <label>Tiket</label><input type="text" name="tiket" required>
                <label>Keterangan</label><textarea name="keterangan"></textarea>
                <button type="submit" name="submit">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Kode</th>
                <th>Retase</th>
                <th>Jenis Angkutan</th>
                <th>Armada</th>
                <th>Tiket</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row) : ?>
                <tr>
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->tanggal; ?></td>
                    <td><?php echo $row->asal; ?></td>
                    <td><?php echo $row->tujuan; ?></td>
                    <td><?php echo $row->kode; ?></td>
                    <td><?php echo $row->retase; ?></td>
                    <td><?php echo $row->jenis_angkutan; ?></td>
                    <td><?php echo $row->armada; ?></td>
                    <td><?php echo $row->tiket; ?></td>
                    <td><?php echo $row->keterangan; ?></td>
                    <td>
                        <button class="edit-btn" 
                            data-id="<?php echo $row->id; ?>" 
                            data-tanggal="<?php echo $row->tanggal; ?>"
                            data-asal="<?php echo $row->asal; ?>"
                            data-tujuan="<?php echo $row->tujuan; ?>"
                            data-kode="<?php echo $row->kode; ?>"
                            data-retase="<?php echo $row->retase; ?>"
                            data-jenis_angkutan="<?php echo $row->jenis_angkutan; ?>"
                            data-armada="<?php echo $row->armada; ?>"
                            data-tiket="<?php echo $row->tiket; ?>"
                            data-keterangan="<?php echo $row->keterangan; ?>">
                            Edit
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal Edit Data -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Data</h2>
            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                <input type="hidden" name="id">
                <label>Tanggal</label><input type="date" name="tanggal" required>
                <label>Asal</label><input type="text" name="asal" required>
                <label>Tujuan</label><input type="text" name="tujuan" required>
                <label>Kode</label><input type="text" name="kode" required>
                <label>Retase</label><input type="number" step="0.1" name="retase" required>
                <label>Jenis Angkutan</label><input type="text" name="jenis_angkutan" required>
                <label>Armada</label><input type="text" name="armada" required>
                <label>Tiket</label><input type="text" name="tiket" required>
                <label>Keterangan</label><textarea name="keterangan"></textarea>
                <button type="submit" name="submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let insertModal = document.getElementById("insertModal");
            let editModal = document.getElementById("editModal");
            let editForm = document.getElementById("editForm");

            document.getElementById("openInsertModal").onclick = function() {
                insertModal.style.display = "block";
            };

    document.querySelectorAll(".edit-btn").forEach(function(btn) {
        btn.addEventListener("click", function() {
            let modal = document.getElementById("editModal");
            let form = modal.querySelector("form");

            form.id.value = this.dataset.id;
            form.tanggal.value = this.dataset.tanggal;
            form.asal.value = this.dataset.asal;
            form.tujuan.value = this.dataset.tujuan;
            form.kode.value = this.dataset.kode;
            form.retase.value = this.dataset.retase;
            form.jenis_angkutan.value = this.dataset.jenis_angkutan;
            form.armada.value = this.dataset.armada;
            form.tiket.value = this.dataset.tiket;
            form.keterangan.value = this.dataset.keterangan;

            modal.style.display = "block";
        });
    });

            document.querySelectorAll(".close").forEach(span => {
                span.onclick = function() {
                    insertModal.style.display = "none";
                    editModal.style.display = "none";
                };
            });
        });
    </script>
    <style>
        .modal { display: none; position: fixed; z-index: 1; padding: 20px; background: rgba(0,0,0,0.5); width: 100%; height: 100%; top: 0; left: 0; }
        .modal-content { background: white; padding: 20px; margin: auto; width: 50%; }
        .responsive-table { width: 100%; border-collapse: collapse; }
        .responsive-table th, .responsive-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
    </style>

    <?php
}
