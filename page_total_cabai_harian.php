<?php
// Initialize the default date
$tanggal = date('Y-m-d');

// Check if the date filter is set
if (isset($_POST['hari_tanggal_filter'])) {
    $tanggal = date('Y-m-d', strtotime($_POST['hari_tanggal_filter']));
}

// SQL query
// $sql = "SELECT tb_pelelangan_pemborong.*, (tb_pelelangan_petani.jumlah_stor * tb_pelelangan_pemborong.harga_per_kg) as total, tb_pelelangan_petani.jumlah_stor, tb_data_peserta_lelang.nik, tb_data_peserta_lelang.nama_peserta 
//         FROM tb_pelelangan_pemborong 
//         JOIN tb_pelelangan_petani ON tb_pelelangan_pemborong.tipe_cabai = tb_pelelangan_petani.tipe_cabai 
//         JOIN tb_data_peserta_lelang ON tb_pelelangan_petani.id_petani = tb_data_peserta_lelang.id 
//         WHERE tb_pelelangan_petani.hari_tanggal = tb_pelelangan_pemborong.hari_tanggal AND tb_pelelangan_pemborong.hari_tanggal = '$tanggal' AND tb_pelelangan_pemborong.status = 'Pemenang'  
//         ORDER BY total DESC";
$sql = "SELECT tb_pelelangan_pemborong.tipe_cabai, 
               SUM(tb_pelelangan_petani.jumlah_stor) AS total_jumlah_stor,
               tb_pelelangan_petani.hari_tanggal,
               SUM(tb_pelelangan_petani.jumlah_stor * tb_pelelangan_pemborong.harga_per_kg) AS total_harga
        FROM tb_pelelangan_pemborong
        JOIN tb_pelelangan_petani ON tb_pelelangan_pemborong.tipe_cabai = tb_pelelangan_petani.tipe_cabai
        WHERE tb_pelelangan_pemborong.hari_tanggal = '$tanggal' 
              AND tb_pelelangan_pemborong.status = 'Pemenang'
        GROUP BY tb_pelelangan_petani.hari_tanggal, tb_pelelangan_pemborong.tipe_cabai
        ORDER BY tb_pelelangan_pemborong.tipe_cabai";


// Execute the SQL query
$datasql = mysqli_query($connect, $sql);
?>

<!-- Page pesanan -->
<h1 class="h3 mb-2 text-gray-800">Total Cabai</h1>
<p class="mb-4">Menampilkan Total Cabai yang ada pada website <a class="text-info" target="_blank" href="../index.php" target="_blank">Lelang Cabai</a>.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Total Cabai</h6>
    </div>

    <div class="card-body">
        <!-- TOMBOL TAMBAH -->
        <div class="d-sm-flex align-items-center justify-content-start mb-4">
            <form id="myForm" action="?page=totalcabaiharian" method="POST">
                <div class="row">
                    <div class="form-group ml-3">
                        <input type="date" name="hari_tanggal_filter" id="hari_tanggal" value="<?= date('Y-m-d', strtotime($tanggal)) ?>" class="form-control bg-secondary" style="color:#fff" />
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Tipe Cabai</th>
                        <th>Jumlah</th>
                        <th>Hari, Tanggal</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = mysqli_fetch_array($datasql)) {

                                        // Kolom "jumlah_stor" sekarang diambil dari hasil query baru
                $jumlah_stor = $data['total_jumlah_stor'];

                // Kolom "total" sekarang diambil dari hasil query baru
                $total = $data['total_harga'];
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['tipe_cabai'] ?></td>
                            <td><?= $jumlah_stor ?> Kg</td>
                            <td><?= date('l, d F Y', strtotime($data['hari_tanggal'])) ?></td>
                            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>
    // JavaScript function to submit the form
    function submitForm() {
        if (document.getElementById("hari_tanggal").value !== "") {
            document.getElementById("myForm").submit();
        }
    }

    // Call the submitForm function when the date input changes
    document.getElementById("hari_tanggal").addEventListener("change", submitForm);
</script>
