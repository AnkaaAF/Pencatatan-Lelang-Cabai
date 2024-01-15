<!-- Page pesanan -->
<h1 class="h3 mb-2 text-gray-800">Pelelangan Petani </h1>
<p class="mb-4"> Menampilkan Data Peleangan Petani yang ada pada website<a class="text-info" target="_blank"
        href="../index.php" target="_blank"> Lelang Cabai</a>.</p>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Data Pelelangan Petani</h6>
    </div>
    
    <div class="card-body">
    
        <!-- TOMBOL TAMBAH -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalTambahPeserta">
            <i class="fas fa-fw fa-plus"></i> Tambah Data
        </button> 
     </div>
        
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NIK</th>
                        <th>Nama Petani</th>
                        <th>Tipe Cabai</th>
                        <th>Jumlah Stor</th>
                        <th>Hari, Tanggal</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $datasql = mysqli_query($connect, "SELECT tb_pelelangan_petani.*, tb_data_peserta_lelang.nik, tb_data_peserta_lelang.nama_peserta 
                        FROM tb_pelelangan_petani 
                        JOIN tb_data_peserta_lelang 
                        ON tb_pelelangan_petani.id_petani = tb_data_peserta_lelang.id");
                        $no = 1;
                        while($data = mysqli_fetch_array($datasql)) { 
                    ?>
                    <tr>
                        <td> <?= $no++ ?></td>
                        <td> <?= $data['nik'] ?></td>
                        <td> <?= $data['nama_peserta'] ?></td>
                        <td> <?= $data['tipe_cabai'] ?></td>
                        <td> <?= $data['jumlah_stor'] ?> Kg</td>
                        <td> <?= date('l, d F Y', strtotime($data['hari_tanggal'])) ?></td>
                        <td> Rp <?= number_format($data['nominal'],0,',','.') ?></td>

                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
    $datasql = mysqli_query($connect, "SELECT tb_pelelangan_petani.*, tb_data_peserta_lelang.nik, tb_data_peserta_lelang.nama_peserta FROM tb_pelelangan_petani JOIN tb_data_peserta_lelang ON tb_pelelangan_petani.id_petani = tb_data_peserta_lelang.id");
    while($data = mysqli_fetch_array($datasql)) { 
?>

<?php } ?>

<!-- Modal -->
<div class="modal fade" id="modalTambahPeserta" tabindex="-1" role="dialog" aria-labelledby="modalTambahPeserta" aria-hidden="true">
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
                <select name="id_petani" id="" class="form-control">
                    <?php
                        $peserta = mysqli_query($connect, "SELECT * FROM tb_data_peserta_lelang where peran = '1'");
                        while($row = mysqli_fetch_array($peserta)){
                    ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nik'] ." - ". $row['nama_peserta'] ?></option>
                    
                    <?php } ?>
                </select>
            </div>
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
                <label for="">Jumlah Stor</label>
                <input type="number" min="0" name="jumlah_stor" placeholder="Jumlah Stor" class="form-control" required/>
            </div>
           
            <div class="form-group">
                <label for="">Hari Tanggal</label>
                <input type="date" name="hari_tanggal" placeholder="Hari Tanggal" class="form-control" required/>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="simpan"  class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- SCRIPT -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- MODAL HAPUS-->
<script>
    $('.flash-hapus').on('click',function(){
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
            if(result.isConfirmed){
                window.location.href = getLink
            }
        })
        return false;
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
<?php unset($_SESSION['flash-y']); } ?>

<!-- alert gagal -->
<?php if (isset($_SESSION['flash-n'])) { ?>
    <script>
        Swal.fire(
                'Gagal',
                '<?php echo $_SESSION['flash-n']; ?>', 
                'error'
                )
    </script>
<?php unset($_SESSION['flash-n']); } ?>