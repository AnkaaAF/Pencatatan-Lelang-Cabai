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
$status_filter = isset($_POST['status_filter']) ? $_POST['status_filter'] : '';

$filter_query = " WHERE tb_pelelangan_pemborong.hari_tanggal = '" . date('Y-m-d', strtotime($tanggal)) . "'";

// if (!empty($tanggal_filtering)) {
//     $filter_query .= " WHERE tb_pelelangan_pemborong.hari_tanggal = '" . date('Y-m-d', strtotime($tanggal_filtering)) . "'";
// }

if (!empty($status_filter)) {
    if (!empty($filter_query)) {
        $filter_query .= " AND";
    } else {
        $filter_query .= " WHERE";
    }
    $filter_query .= " tb_pelelangan_pemborong.status = '$status_filter'";
}

$datasql = mysqli_query($connect, "SELECT tb_data_peserta_lelang.nik, tb_data_peserta_lelang.nama_peserta,
                                   tb_pelelangan_pemborong.id_pemborong,
                                   tb_pelelangan_pemborong.id,
                                   tb_pelelangan_pemborong.tipe_cabai, tb_pelelangan_pemborong.harga_per_kg,
                                   tb_pelelangan_pemborong.uang_jaminan, 
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


<h1 class="h3 mb-2 text-gray-800">Data Pelelangan Pemborong</h1>
<p class="mb-4">Menampilkan Data Pelelangan Pemborong yang ada pada website <a class="text-info" target="_blank" href="../index.php" target="_blank">Lelang Cabai</a>.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Data Pelelangan Pemborong</h6>
    </div>
    <!-- Menampilkan total cabai per tipe -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <h5>
                    <?= isset($_POST['hari_tanggal_filter']) ? date('l, d F Y', strtotime($tanggal)) : date('l, d F Y') ?>
                </h5>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Tipe Cabai</th>
                        <th>Total Cabai</th>
                    </tr>
                    <?php
                    foreach ($total_per_tipe as $tipe_cabai => $jumlah) {
                    ?>
                        <tr>
                            <td>
                                <?= $tipe_cabai ?>
                            </td>
                            <td>
                                <?= $jumlah ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <div class="col-md-8 text-right">
                <a href="../admin/function/func_pelelangan.php?selesai=true" class="btn btn-primary">Selesai</a>
            </div>
        </div>
    </div>

    <!-- Page pesanan -->

    <!-- TOMBOL TAMBAH -->
    <div class="d-sm-flex align-items-center justify-content-start p-4 mb-2">

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalTambahPemborong">
            <i class="fas fa-fw fa-plus"></i> Bid
        </button>

        <form id="myForm" action="?page=pelelanganpemborong" method="POST" class="form-horizontal">
            <div class="form-row m-3">
                <div class="col">

                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive p-3">
        <form action="" method="POST">
            <div class="row">

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
                    <th>Uang Jaminan</th>
                    <th>Total Bayar</th>
                    <th>Kurang bayar</th>
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
                <?php $kurang = $data['total_bayar'] - $data['uang_jaminan'] ?>
                <td> Rp<?= number_format($data['harga_per_kg'], 0, ',', '.') ?></td>
                <td> Rp<?= number_format($data['uang_jaminan'], 0, ',', '.') ?></td>
                <td> Rp<?= number_format($data['total_bayar'], 0, ',', '.') ?></td>
                <td>
                <?php if ($data['status'] !== 'Kalah') : ?>
                    Rp<?= number_format($kurang, 0, ',', '.') ?>
                <?php else : ?>
                    Rp 0
                <?php endif; ?>
            </td>


                <td>
                    <?= $data['status'] ?>
                    <?php if ($data['status'] != "Kalah") : ?>
                    <a href="#" data-toggle="modal" data-target="#modaleditStatus<?= $data['id']; ?>" \ <?php endif; ?> </td>
            </tr>
            <td>
    </div>
</div>
</form>
</div>
</div>
</div>
<?php
        }
        // Tutup tabel terakhir setelah loop selesai
        echo '</tbody></table></div>';
?>

<!-- Modal Tambah data -->
<div class="modal fade" id="modalTambahPemborong" tabindex="-1" role="dialog" aria-labelledby="modalTambahPemborong" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="../admin/function/func_pelelangan.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Data Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">NIK</label>
                        <select name="id_pemborong" id="" class="form-control">
                            <?php
                            $peserta = mysqli_query($connect, "SELECT * FROM tb_data_peserta_lelang where peran = '2'");
                            while ($row = mysqli_fetch_array($peserta)) {
                            ?>
                                <option value="<?= $row['id'] ?>">
                                    <?= $row['nik'] . " - " . $row['nama_peserta'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tipe Cabai</label>
                        <select name="tipe_cabai" id="tipe_cabai" class="form-control" required>
                            <option value="">-- Pilih Tipe Cabai --</option>
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
                        <label for="">Minimal Harga Lelang</label>
                        <input type="number" min="1000" readonly name="min_harga_per_kg" id="min_harga_per_kg" placeholder="Min Harga / Kg" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="">Harga / Kg</label>
                        <input type="number" min="1000" name="harga_per_kg" placeholder="Harga / Kg" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="">Uang Jaminan</label>
                        <input type="number" min="1000" name="uang_jaminan" placeholder="Rp" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label for="">Hari, Tanggal</label>
                        <input type="date" name="hari_tanggal" placeholder="Hari, Tanggal" value="<?= date('Y-m-d') ?>" class="form-control" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="simpan-pemborong" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('tipe_cabai').addEventListener('change', function() {
        var tipe_cabai = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../admin/function/func_pelelangan.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                document.getElementById('min_harga_per_kg').value = data.min_harga;
            }
        };
        var params = 'tipe_cabai=' + tipe_cabai;
        xhr.send(params);
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modalTambahPemborong = document.getElementById("modalTambahPemborong");
        var hargaKgInput = document.getElementById("harga_per_kg");

        // Fungsi untuk memeriksa apakah nilai input lebih dari 1000
        function isHargaValid(value) {
            return value >= 1000;
        }

        // Fungsi untuk menampilkan pesan kesalahan jika nilai input tidak valid
        function showError() {
            alert("Harga per Kg harus di atas atau sama dengan 1000.");
            hargaKgInput.value = ""; // Hapus nilai yang tidak valid
        }

        // Event listener untuk membuka modal tambah data
        modalTambahPemborong.addEventListener("show.bs.modal", function() {
            // Event listener untuk memeriksa input setiap kali nilainya berubah
            hargaKgInput.addEventListener("change", function() {
                var hargaKgValue = parseInt(hargaKgInput.value, 10);

                // Periksa apakah nilai input lebih dari atau sama dengan 1000
                if (!isHargaValid(hargaKgValue)) {
                    showError();
                }
            });

            // Event listener untuk memastikan bahwa input diisi dengan harga di atas atau sama dengan 1000 saat form disubmit
            document.querySelector("form").addEventListener("submit", function(event) {
                var hargaKgValue = parseInt(hargaKgInput.value, 10);

                if (!isHargaValid(hargaKgValue)) {
                    showError();
                    event.preventDefault(); // Mencegah pengiriman form jika input tidak valid
                }
            });
        });
    });
</script>