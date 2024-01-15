<?php
if (empty($_SESSION['username'])) {
    header('location: ../Auth/page-login.php');
}
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-2">
    <h1 class="h4 mb-0 text-gray-800">Dashboard</h1>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_SESSION['flash-y'])) { ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 15000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'success',
            title: '<?php echo $_SESSION['flash-y']; ?>'
        })
    </script>
    <?php unset($_SESSION['flash-y']);
} ?>

<?php if (isset($_SESSION['flash-n'])) { ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 15000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'error',
            title: '<?php echo $_SESSION['flash-n']; ?>'
        })
    </script>
    <?php unset($_SESSION['sukses']);
} ?>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-12 col-lg-7 mb-1">
        <div class="card shadow mb-3">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-info">Lelang Cabai</h6>
            </div>
            <div class="card-body">
                <center>
                    <img class="logo2" src="images/logo-full-barukuning.png" alt="AdminLTE Logo" width="300"
                        style="z-index: 1;">
                </center>
                <br>
                <p align="justify"><strong>Lelang Cabai</strong> | Titik Kumpul Cabe dan Sayuran Tempel | Tempel,
                    Lumbungrejo, Kec. Tempel, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55552 | 0888-0664-1825 | Buka
                    16.00 - 20.00
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php
    // mengambil data table
    $data_admin = mysqli_query($connect, "SELECT * FROM tbl_admin");
    $data_petani = mysqli_query($connect, "SELECT * FROM tb_data_peserta_lelang WHERE peran = '1'");
    $data_pemborong = mysqli_query($connect, "SELECT * FROM tb_data_peserta_lelang WHERE peran = '2'");

    // jumlah data table
    $jumlah_admin = mysqli_num_rows($data_admin);
    $jumlah_petani = mysqli_num_rows($data_petani);
    $jumlah_pemborong = mysqli_num_rows($data_pemborong);
    ?>

    <!-- DATA PRODUK -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xxs font-weight-bold text-success text-uppercase mb-1">
                            <a class="text-info" href="index.php?page=produk"> Data Petani </a>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-white-800">
                            <?php echo $jumlah_petani; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-white-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END DATA PRODUK -->

    <!-- DATA PRODUK -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xxs font-weight-bold text-success text-uppercase mb-1">
                            <a class="text-info" href="index.php?page=produk"> Data Pemborong </a>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-white-800">
                            <?php echo $jumlah_pemborong; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-white-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END DATA PRODUK -->

    <!-- DATA ADMIN -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xxs font-weight-bold text-info text-uppercase mb-1">
                            <a class="text-info" href="index.php?page=administrator"> ADMIN </a>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-white-800">
                            <?php echo $jumlah_admin; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-white-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END DATA ADMIN -->

        <!-- TOMBOL TAMBAH -->
        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <form action="../admin/Views/cetak_laporan_hargacabai.php" method="POST" target="_blank">
                <div class="row">
                    <!-- <div class="from-group">
                        <button type="submit" class="btn btn-info ml-2"> <i class="fas fa-fw fa-share-alt"></i> Cetak Data</button>
                    </div> -->
                    <!-- <div class="form-group ml-3">
                        <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" class="form-control bg-secondary" style="color:#fff" />
                    </div> -->
                </div>
            </form>
        </div>
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahHargaModal">Tambah Harga Percabai</button>
            </div>
<!-- TOMBOL TAMBAH -->
<div class="row">
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-3">
            <div class="card-body">
                <h5>
                    <?= isset($_POST['hari_tanggal_filter']) ? date('l, d F Y', strtotime($tanggal)) : date('l, d F Y') ?>
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="hargaPercabaiTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tipe Cabai</th>
                                <th>Harga Percabai (per Kg)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Ambil data harga percabai dari database
                            $queryHargaPercabai = "SELECT * FROM tb_harga_percabai ORDER BY tipecabai DESC";
                            $resultHargaPercabai = mysqli_query($connect, $queryHargaPercabai);

                            while ($rowHargaPercabai = mysqli_fetch_assoc($resultHargaPercabai)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $rowHargaPercabai['tipecabai']; ?>
                                    </td>
                                    <td>Rp
                                        <?php echo $rowHargaPercabai['harga_percabai']; ?>
                                    </td>
                                    <td>
                                        <!-- <a href="../function/func_hargacabaidasar.php" data-toggle="modal" data-target="#modaleditNominal<?= $data['tipecabai']; ?>" class="btn btn-default"><i class="fa fa-edit"></i></a> -->
                                        <a href="#" data-toggle="modal"
                                            data-target="#modaleditNominal<?= $rowHargaPercabai['tipecabai']; ?>"
                                            class="btn btn-default"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Harga Percabai -->
<div class="modal fade" id="tambahHargaModal" tabindex="-1" role="dialog" aria-labelledby="tambahHargaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../admin/function/func_hargacabaidasar.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahHargaModalLabel">Tambah Harga Percabai Harian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Tipe Cabai</label>
                        <select name="tipe_cabai" id="" class="form-control" required>
                            <option value="RM">RM</option>
                            <option value="ORI">ORI</option>
                            <option value="ORI-KECIL">ORI-KECIL</option>
                            <option value="SP">SP</option>
                            <option value="SP1">SP1</option>
                            <option value="ELX">ELX</option>
                            <option value="TW">TW</option>
                            <option value="CPLK">CPLK</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Harga / Kg</label>
                        <input type="number" min="0" name="harga_percabai" placeholder="" class="form-control"
                            required />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

// Ambil data harga percabai dari database
$queryHargaPercabai = "SELECT * FROM tb_harga_percabai ORDER BY tipecabai DESC";
$resultHargaPercabai = mysqli_query($connect, $queryHargaPercabai);

while ($data = mysqli_fetch_assoc($resultHargaPercabai)) {

    ?>

    <!-- Modal Update -->
    <div class="modal fade" id="modaleditNominal<?= $data['tipecabai']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="modaleditNominal<?= $data['tipecabai']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="../admin/function/func_hargacabaidasar.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nominal</label>
                            <input type="hidden" min="0" name="tipe_cabai" value="<?= $data['tipecabai'] ?>"
                                class="form-control" required />
                            <input type="number" min="0" name="harga_percabai" placeholder="Nominal" class="form-control"
                                required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php } ?>

<!-- Content Row -->
<div class="row">
    <div class="col-xl-5 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-info">Profil</h6>
            </div>
            <div class="card-body">
                <pre>
<strong>Nama     : </strong><?php echo $_SESSION['nama']; ?> 
<strong>Email    : </strong><?php echo $_SESSION['email']; ?> 
<strong>Username : </strong><?php echo $_SESSION['username']; ?>
                </pre>
            </div>
        </div>
    </div>
</div>