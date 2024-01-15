<!-- Page pesanan -->
<h1 class="h3 mb-2 text-gray-800">Data Peserta </h1>
<p class="mb-4"> Menampilkan Data Peserta yang ada pada website<a class="text-info" target="_blank"
        href="../index.php" target="_blank"> Lelang Cabai</a>.</p>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Data Peserta Lelang</h6>
    </div>
    
    <div class="card-body">
    
        <!-- TOMBOL TAMBAH -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalTambahPeserta">
            <i class="fas fa-fw fa-plus"></i> Tambah Data
        </button> 
     </div>

<!-- Tabel untuk Petani -->
<h2 class="h3 mb-2 text-gray-800">Data Petani</h2>
<table class="table table-bordered" id="dataTablePetani" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>NO</th>
            <th>NIK</th>
            <th>Nama Peserta</th>
            <th>No Hp</th>
            <th>Alamat</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $datasqlPetani = mysqli_query($connect, "SELECT * FROM tb_data_peserta_lelang WHERE peran = 1");
            $no = 1;
            while($dataPetani = mysqli_fetch_array($datasqlPetani)) { 
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $dataPetani['nik'] ?></td>
            <td><?= $dataPetani['nama_peserta'] ?></td>
            <td><?= $dataPetani['no_hp'] ?></td>
            <td><?= $dataPetani['alamat'] ?></td>
            <td>
                <a href="../admin/function/hapus_datapeserta.php?id=<?= $dataPetani['id']; ?>" class="btn btn-danger flash-hapus"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>


<!-- Tabel untuk Pemborong -->
<h2 class="h3 mb-2 text-gray-800">Data Pemborong</h2>
<table class="table table-bordered" id="dataTablePemborong" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>NO</th>
            <th>NIK</th>
            <th>Nama Peserta</th>
            <th>No Hp</th>
            <th>Alamat</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $datasqlPemborong = mysqli_query($connect, "SELECT * FROM tb_data_peserta_lelang WHERE peran = 2");
            $no = 1;
            while($dataPemborong = mysqli_fetch_array($datasqlPemborong)) { 
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $dataPemborong['nik'] ?></td>
            <td><?= $dataPemborong['nama_peserta'] ?></td>
            <td><?= $dataPemborong['no_hp'] ?></td>
            <td><?= $dataPemborong['alamat'] ?></td>
            <td>
                <a href="../admin/function/hapus_datapeserta.php?id=<?= $dataPemborong['id']; ?>" class="btn btn-danger flash-hapus"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="modalTambahPeserta" tabindex="-1" role="dialog" aria-labelledby="modalTambahPeserta" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="../admin/function/func_peserta.php" method="POST">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Data Peserta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">NIK</label>
                <input type="text" name="nik" placeholder="NIK" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="">Nama Peserta</label>
                <input type="text" name="nama_peserta" placeholder="Nama Peserta" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="">Nomor HP</label>
                <input type="text" name="no_hp" placeholder="Nomor HP" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="">Alamat</label>
                <textarea name="alamat" cols="30" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="">Peran</label>
                <select name="peran" id="" class="form-control">
                    <option value="1">Petani</option>
                    <option value="2">Pemborong</option>
                </select>
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