<!-- Page pesanan -->
<h1 class="h3 mb-2 text-gray-800">Tabungan Petani </h1>
<p class="mb-4"> Menampilkan Data Tabungan Petani yang ada pada website<a class="text-info" target="_blank"
        href="../index.php" target="_blank"> Lelang Cabai</a>.</p>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Tabungan Petani</h6>
    </div>
    
    <div class="card-body">
    
        <!-- TOMBOL TAMBAH -->
        <div class="d-sm-flex align-items-center justify-content-start mb-4">

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
                        <th>Hari, Tanggal</th>
                        <th>Jumlah Tabungan</th>
                        <th>Menabung</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $datasql = mysqli_query($connect, "SELECT tb_tabungan_petani.*, tb_data_peserta_lelang.nik, tb_data_peserta_lelang.nama_peserta FROM tb_tabungan_petani JOIN tb_data_peserta_lelang ON tb_tabungan_petani.id_petani = tb_data_peserta_lelang.id");
                        $no = 1;
                        while($data = mysqli_fetch_array($datasql)) { 
                    ?>
                    <tr>
                        <td> <?= $no++ ?></td>
                        <td> <?= $data['nik'] ?></td>
                        <td> <?= $data['nama_peserta'] ?></td>
                        <td> <?= date('l, d F Y', strtotime($data['hari_tanggal'])) ?></td>
                        <td> Rp <?= number_format($data['jumlah_tabungan'],0,',','.') ?></td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#modaleditNominal<?=$data['id']; ?>" class="btn btn-info" class="fa fa-edit"></i></a>
                        </td>
                        <td>
                            <a href="../admin/function/hapus_datatabungan.php?id=<?=$data['id']; ?>" class="btn btn-danger flash-hapus"><i class="bi bi-trash"></i></a>
                        </td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
    $datasql = mysqli_query($connect, "SELECT tb_tabungan_petani.*, tb_data_peserta_lelang.nik, tb_data_peserta_lelang.nama_peserta FROM tb_tabungan_petani JOIN tb_data_peserta_lelang ON tb_tabungan_petani.id_petani = tb_data_peserta_lelang.id");
    while($data = mysqli_fetch_array($datasql)) { 
?>
<!-- Modal -->
<div class="modal fade" id="modaleditNominal<?=$data['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modaleditNominal<?=$data['id']; ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="../admin/function/func_tabungan.php" method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label for="">Nama Petani</label>
                <input type="hidden" min="0" name="id" value="<?= $data['id'] ?>" placeholder="Nominal" class="form-control" readonly required/>
                <input type="text" min="0" name="nama_peserta" value="<?= $data['nama_peserta'] ?>" placeholder="Nominal" class="form-control" readonly required/>
            </div>
            <div class="form-group">
                <label for="">Menabung</label>
                <input type="number" min="0" name="menabung" placeholder="Nominal" class="form-control" />
            </div>
            <div class="form-group">
                <label for="">Mengambil</label>
                <input type="number" min="0" name="mengambil" placeholder="Nominal" class="form-control" />
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="update-tabungan"  class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php } ?>

<!-- Modal -->
<div class="modal fade" id="modalTambahPeserta" tabindex="-1" role="dialog" aria-labelledby="modalTambahPeserta" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="../admin/function/func_tabungan.php" method="POST">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Menabung</h5>
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
                <label for="">Menabung</label>
                <input type="number" min="0" name="jumlah_tabungan" placeholder="Nominal Awal" class="form-control" required/>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="simpan-tabungan"  class="btn btn-primary">Simpan</button>
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