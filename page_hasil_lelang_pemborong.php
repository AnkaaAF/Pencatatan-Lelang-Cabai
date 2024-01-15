<?php
error_reporting(0);

if (isset($_GET['id'])) {
    // Mendapatkan ID dari permintaan POST
    $id = $_GET['id'];

    // Query untuk memperbarui status_pembayaran
    $sql = "UPDATE tb_pelelangan_pemborong SET status_pembayaran = '1' WHERE id = $id";
    mysqli_query($connect, $sql);
}
?>

<!-- Page pesanan -->
<h1 class="h3 mb-2 text-gray-800">Pembayaran Pemborong </h1>
<p class="mb-4"> Menampilkan Pembayaran Pemborong yang ada pada website<a class="text-info" target="_blank" href="../index.php" target="_blank"> Lelang Cabai</a>.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Pembayaran Pemborong</h6>
    </div>

    <div class="card-body">
        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <form action="../admin/Views/cetak_laporan_lelang_pemborong.php" method="POST" target="_blank">
                <div class="row">
                    <div class="from-group">
                        <button type="submit" class="btn btn-info ml-2"> <i class="fas fa-fw fa-share-alt"></i> Cetak Data</button>
                    </div>
                    <div class="form-group ml-3">
                        <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" class="form-control bg-secondary" style="color:#fff" />
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NIK</th>
                        <th>Nama Pemborong</th>
                        <th>Tipe Cabai</th>
                        <th>Harga / Kg</th>
                        <th>Hari, Tanggal</th>
                        <th>Nominal Bayar</th>
                        <th>Status</th>
                        <th>Validasi Terbayar</th>
                        <th>Status Pembayaran</th>
                        <th>Action</th>
                        <th>Unggah Nota</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $datasql = mysqli_query($connect, "SELECT tb_data_peserta_lelang.nik, tb_data_peserta_lelang.nama_peserta,
                                    tb_pelelangan_pemborong.id AS pemborong_id,
                                    tb_pelelangan_pemborong.status_pembayaran,
                                    tb_pelelangan_pemborong.nota,
                                    tb_pelelangan_pemborong.tipe_cabai, tb_pelelangan_pemborong.harga_per_kg,
                                    tb_pelelangan_pemborong.hari_tanggal, 
                                    SUM(tb_pelelangan_petani.jumlah_stor * tb_pelelangan_pemborong.harga_per_kg) AS total_bayar,
                                    tb_pelelangan_pemborong.status
                                    FROM `tb_pelelangan_pemborong`
                                    JOIN tb_pelelangan_petani
                                    ON tb_pelelangan_pemborong.tipe_cabai = tb_pelelangan_petani.tipe_cabai
                                    JOIN tb_data_peserta_lelang
                                    ON tb_pelelangan_pemborong.id_pemborong = tb_data_peserta_lelang.id
                                    WHERE tb_pelelangan_petani.hari_tanggal = tb_pelelangan_pemborong.hari_tanggal
                                    AND tb_pelelangan_pemborong.status = 'Pemenang'
                                    GROUP BY tb_data_peserta_lelang.nik, tb_pelelangan_pemborong.tipe_cabai, tb_pelelangan_pemborong.harga_per_kg, tb_pelelangan_pemborong.hari_tanggal, tb_pelelangan_pemborong.status, tb_pelelangan_pemborong.id_pemborong
                                    ORDER BY total_bayar DESC");
                    $no = 1;
                    while ($data = mysqli_fetch_assoc($datasql)) {
                    ?>
                        <tr>
                            <td> <?= $no++ ?></td>
                            <td> <?= $data['nik'] ?></td>
                            <td> <?= $data['nama_peserta'] ?></td>
                            <td> <?= $data['tipe_cabai'] ?></td>
                            <?php $kurang = $data['total_bayar'] - $data['uang_jaminan'] ?>
                            <td> Rp <?= number_format($data['harga_per_kg'], 0, ',', '.') ?></td>
                            <td> <?= date('l, d F Y', strtotime($data['hari_tanggal'])) ?></td>
                            <td> Rp <?= number_format($data['total_bayar'], 0, ',', '.') ?></td>
                            <td> <?= $data['status'] ?></td>
                            <td>
                                <?php if ($data['status_pembayaran'] == '1') : ?>
                                    <p>
                                        <span class="badge badge-success">Terbayar</span>
                                    </p>
                                    <?php if ($data['nota']) : ?>
                                        <a href="./Views/uploads/<?= $data['nota'] ?>" target="_blank">Link Nota</a>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <span class="badge badge-danger">Belum Terbayar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($data['status_pembayaran'] == '1') : ?>
                                    <button class="btn btn-sm btn-success" disabled> Status Sudah Di Update
                                    </button>
                                <?php else : ?>
                                    <!-- <button class="btn btn-sm btn-primary update-status-pemborong" data-id="<?= $data['pemborong_id']; ?>">
                                        <i class="fas fa-edit"></i> Update Status
                                    </button> -->
                                <?php endif; ?> 
                            </td>
                            <td>
                                <a href="../admin/function/hapus_lelang_pemborong.php?id=<?= $data['id_pemborong']; ?>" class="btn btn-danger flash-hapus"><i class="bi bi-trash"></i></a>
                            </td>
                            <td>
                                <form action="../admin/function/upload_nota.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_pemborong" value="<?= $data['pemborong_id']; ?>">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="nota" name="nota" accept=".jpg, .jpeg, .png" required>
                                        <label class="custom-file-label" for="nota">Pilih Nota</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Unggah</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Menampilkan nama file pada label file saat dipilih -->
<script>
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });
</script>

<!-- MODAL HAPUS -->
<script>
    $('.flash-hapus').on('click', function() {
        var getLink = $(this).attr('href');
        Swal.fire({
            title: "Yakin hapus data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonColor: '#3085d6',
            cancelButtonText: "Batal"
        }).then(result => {
            //jika klik ya maka arahkan ke proses.php
            if (result.isConfirmed) {
                window.location.href = getLink;
            }
        });
        return false;
    });
</script>

<!-- MODAL UPDATE STATUS -->
<script>
    $('.update-status-pemborong').on('click', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: "Update Status Pembayaran?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: "Batal"
        }).then(result => {
            if (result.isConfirmed) {
                // Redirect ke halaman update status dengan membawa parameter id
                window.location.href = 'index.php?page=hasillelanganpemborong&id=' + id;
            }
        });
    });
</script>

<!-- alert berhasil -->
<?php if (isset($_SESSION['flash-y'])) { ?>
    <script>
        Swal.fire(
            'Berhasil',
            '<?php echo $_SESSION['flash-y']; ?>',
            'success'
        )
    </script>
<?php unset($_SESSION['flash-y']);
} ?>

<!-- alert gagal -->
<?php if (isset($_SESSION['flash-n'])) { ?>
    <script>
        Swal.fire(
            'Gagal',
            '<?php echo $_SESSION['flash-n']; ?>',
            'error'
        )
    </script>
<?php unset($_SESSION['flash-n']);
} ?>