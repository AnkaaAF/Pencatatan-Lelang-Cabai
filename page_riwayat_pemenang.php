<?php
error_reporting(0);

$tipeCabai = ["RM", "ORI", "ORI-KECIL", "SP", "SP1", "ELX", "TW", "CPLK"];

// Inisialisasi variabel $total_per_tipe
$total_per_tipe = array();

// Inisialisasi tanggal default
$tanggal = date('Y-m-d');

// Cek apakah ada pengiriman data form dengan filter tanggal
if (isset($_POST['tipe_cabai_filter']) || isset($_POST['tanggal_filtering'])) {
    // Ambil tanggal dari form
    $tanggal = date('Y-m-d', strtotime($_POST['tanggal_filtering']));

    $tanggal_harian = isset($_POST['tanggal_filtering']) ? date('l, d F Y', strtotime($tanggal)) : date('l, d F Y');
}

// Mengambil total cabai per tipe pada tanggal tertentu
$query = "SELECT `tipe_cabai`, SUM(`jumlah_stor`) as total_jumlah_stor FROM `tb_pelelangan_petani` 
WHERE `hari_tanggal` = '$tanggal' GROUP BY `tipe_cabai`";
$result = mysqli_query($connect, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $tipe_cabai = $row['tipe_cabai'];
    $total_jumlah_stor = $row['total_jumlah_stor'];

    $total_per_tipe[$tipe_cabai] = $total_jumlah_stor;
}

$tanggal_filtering = isset($_POST['tanggal_filtering']) ? $_POST['tanggal_filtering'] : '';
$bulan_filter = isset($_POST['bulan_filter']) ? $_POST['bulan_filter'] : '';
$status_filter = isset($_POST['status_filter']) ? $_POST['status_filter'] : '';

$filter_query = "";

if (!empty($tanggal_filtering)) {
    $filter_query .= " WHERE tb_pelelangan_pemborong.hari_tanggal = '" . date('Y-m-d', strtotime($tanggal_filtering)) . "'";
}

// Tambahkan kondisi untuk memfilter hanya data pemenang
$filter_query .= !empty($filter_query) ? " AND" : " WHERE";
$filter_query .= " tb_pelelangan_pemborong.status = 'Pemenang'";


if (!empty($bulan_filter)) {
    $filter_query .= " AND MONTH(tb_pelelangan_pemborong.hari_tanggal) = '" . date('m', strtotime($bulan_filter)) . "'";
    $filter_query .= " AND YEAR(tb_pelelangan_pemborong.hari_tanggal) = '" . date('Y', strtotime($bulan_filter)) . "'";
}

$datasql = mysqli_query($connect, "SELECT tb_data_peserta_lelang.nik, tb_data_peserta_lelang.nama_peserta,
                                   tb_pelelangan_pemborong.id_pemborong,
                                   tb_pelelangan_pemborong.id,
                                   tb_pelelangan_pemborong.tipe_cabai, tb_pelelangan_pemborong.harga_per_kg,
                                   tb_pelelangan_pemborong.hari_tanggal, 
                                   SUM(tb_pelelangan_petani.jumlah_stor * tb_pelelangan_pemborong.harga_per_kg) AS total_bayar,
                                   tb_pelelangan_pemborong.status
                                   FROM `tb_pelelangan_pemborong`
                                   JOIN tb_pelelangan_petani
                                   ON tb_pelelangan_pemborong.tipe_cabai = tb_pelelangan_petani.tipe_cabai
                                   JOIN tb_data_peserta_lelang
                                   ON tb_pelelangan_pemborong.id_pemborong = tb_data_peserta_lelang.id"
    . $filter_query .
    " GROUP BY tb_data_peserta_lelang.nik, tb_pelelangan_pemborong.tipe_cabai, tb_pelelangan_pemborong.harga_per_kg, tb_pelelangan_pemborong.hari_tanggal, tb_pelelangan_pemborong.status, tb_pelelangan_pemborong.id_pemborong
                                   ORDER BY tb_pelelangan_pemborong.tipe_cabai DESC, 
                                   CASE 
                                        WHEN tb_pelelangan_pemborong.status = 'Pemenang' THEN 1
                                        ELSE 2
                                   END");
?>

<head>
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<!-- alert berhasil -->
<?php if (isset($_SESSION['flash-y'])) { ?>
    <?php $pesan = $_SESSION['flash-y']; ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        <?php if (strpos($pesan, "Gagal")) : ?>
            Toast.fire({
                icon: 'error',
                title: '<?php echo $_SESSION['flash-y']; ?>'
            })
        <?php else : ?>
            Toast.fire({
                icon: 'success',
                title: '<?php echo $_SESSION['flash-y']; ?>'
            })
        <?php endif; ?>
    </script>
<?php unset($_SESSION['flash-y']);
} ?>


<h1 class="h3 mb-2 text-gray-800">Riwayat Lelang</h1>
<p class="mb-4">Menampilkan Riwayat Lelang yang ada pada website <a class="text-info" target="_blank" href="../index.php" target="_blank">Lelang Cabai</a>.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Riwayat Lelang</h6>
    </div>

    <div class="table-responsive p-3">
        <form action="" method="POST">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="tanggal_filtering">Filter Tanggal</label>
                        <input type="date" name="tanggal_filtering" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                 <div class="form-group">
                    <label for="bulan_filter">Filter Bulan</label>
                    <input type="month" name="bulan_filter" class="form-control">
                 </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="status_filter">Filter Status</label>
                        <select name="status_filter" class="form-control">
                            <option value="">Semua</option>
                            <option value="Pending">Pending</option>
                            <option value="Pemenang">Pemenang</option>
                            <option value="Kalah">Kalah</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <?php
        $no = 1; // Inisialisasi nomor
        $currentCabai = null;

        while ($data = mysqli_fetch_assoc($datasql)) {
            if ($currentCabai !== $data['tipe_cabai']) {
                // Jika tipe cabai berbeda dengan tipe cabai sebelumnya, buat tabel baru
                if ($currentCabai !== null) {
                    echo '</tbody></table></div>'; // Tutup tabel sebelumnya jika tipe cabai berbeda
                    $no = 1; // Set nomor kembali ke 1 saat tabel baru dimulai
                }

                // Membuat tabel baru
                echo '<div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NIK</th>
                    <th>Nama Pemborong</th>
                    <th>Tipe Cabai</th>
                    <th>Harga / Kg</th>
                    <th>Hari, Tanggal</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';
                $currentCabai = $data['tipe_cabai'];
            }
        ?>
            <tr>
                <td><?= $no++ ?></td> <!-- Perbaiki nomor di sini -->
                <td><?= $data['nik'] ?></td>
                <td><?= $data['nama_peserta'] ?></td>
                <td><?= $data['tipe_cabai'] ?></td>
                <td> Rp<?= number_format($data['harga_per_kg'], 0, ',', '.') ?></td>
                <td><?= date('l, d F Y', strtotime($data['hari_tanggal'])) ?></td>
                <td> Rp<?= number_format($data['total_bayar'], 0, ',', '.') ?></td>
                <td>
                    <?= $data['status'] ?>
                    <?php if ($data['status'] != "Kalah") : ?>
                        <a href="#" data-toggle="modal" data-target="#modaleditStatus<?= $data['id']; ?>" \ <?php endif; ?> </td>
            </tr>
            <!-- Modal -->
            <!-- <div class="modal fade" id="modaleditStatus<?= $data['id']; ?>" tabindex="-1" role="dialog"
                 aria-labelledby="modaleditStatus<?= $data['id']; ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="../admin/function/func_pelelangan.php" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <input type="hidden" name="id" value="<?= $data['id'] ?>"
                                           placeholder="Nominal" class="form-control" /> -->
            <!-- <select name="status" id="" class="form-control">
                                        <option value="Pending">Pending</option>
                                        <option value="Pemenang">Pemenang</option>
                                        <option value="Kalah">Kalah</option>
                                    </select> -->
    </div>
</div>
<!-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                <button type="submit" name="update-status"
                                        class="btn btn-primary">Update</button>
                            </div> -->
</form>
</div>
</div>
</div>
<?php
        }
        // Tutup tabel terakhir setelah loop selesai
        echo '</tbody></table></div>';
?>