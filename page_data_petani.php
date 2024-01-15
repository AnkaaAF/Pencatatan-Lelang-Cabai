<!-- Page pesanan -->
<h1 class="h3 mb-2 text-gray-800">Data Petani </h1>
<p class="mb-4"> Menampilkan Data Peserta Petani yang ada pada website<a class="text-info" target="_blank" href="../index.php" target="_blank"> Lelang Cabai</a>.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Data Peserta Petani</h6>
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
                    <th>Nama Petani</th>
                    <th>No Hp</th>
                    <th>Alamat</th>
                    <th>Edit</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $datasqlPetani = mysqli_query($connect, "SELECT * FROM tb_data_peserta_lelang WHERE peran = 1");
                $no = 1;
                while ($dataPetani = mysqli_fetch_array($datasqlPetani)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $dataPetani['nik'] ?></td>
                        <td><?= $dataPetani['nama_peserta'] ?></td>
                        <td><?= $dataPetani['no_hp'] ?></td>
                        <td><?= $dataPetani['alamat'] ?></td>
                        <td> <a class="btn btn-warning btn-edit" data-toggle="modal" data-target="#modalEditPetani<?= $dataPetani["id"] ?>"><i class="bi bi-pencil"></i></a>
                        <td><a href="../admin/function/hapus_peserta_petani.php?id=<?= $dataPetani['id']; ?>" class="btn btn-danger flash-hapus"><i class="bi bi-trash"></i></a></td>
                        </td>
                    </tr>

                    <!-- Modal edit Petani Data -->
                    <div class="modal fade" id="modalEditPetani<?= $dataPetani["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditPetani" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form action="../admin/function/func_peserta_petani.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Petani</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?php echo $dataPetani['id'] ?>">
                                        <div class="form-group">
                                            <label for="">NIK</label>
                                            <input type="text" name="nik" placeholder="Masukan NIK" class="form-control" value="<?php echo $dataPetani['nik'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama Peserta</label>
                                            <input type="text" name="nama_peserta" placeholder="Nama Peserta" class="form-control" value="<?php echo $dataPetani['nama_peserta'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nomor HP</label>
                                            <input type="text" name="no_hp" placeholder="Nomor HP" class="form-control" value="<?php echo $dataPetani['no_hp'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Alamat</label>
                                            <textarea name="alamat" cols="30" rows="3" class="form-control"><?php echo $dataPetani['alamat'] ?></textarea>
                                        </div>
                                        <div class="form-group hidden">
                                            <label for="">Peran</label>
                                            <select name="peran" id="" class="form-control">
                                                <option value="1" selected>Petani</option>
                                            </select>
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
                <?php
                } ?>
            </tbody>
        </table>

        <!-- Modal tambah -->
        <div class="modal fade" id="modalTambahPeserta" tabindex="-1" role="dialog" aria-labelledby="modalTambahPeserta" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="../admin/function/func_peserta_petani.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Data Peserta Petani</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">NIK</label>
                                <input type="text" name="nik" placeholder="NIK" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="">Nama Peserta</label>
                                <input type="text" name="nama_peserta" placeholder="Nama Peserta" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="">Nomor HP</label>
                                <input type="text" name="no_hp" placeholder="Nomor HP" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea name="alamat" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="form-group hidden">
                                <label for="">Peran</label>
                                <select name="peran" id="" class="form-control">
                                    <option value="1" selected>Petani</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SCRIPT -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- MODAL EDIT -->
        <script>
            $(document).ready(function() {
                $('.btn-edit').on('click', function() {
                    var id = $(this).data('id');

                    // Fetch existing data from the server using AJAX
                    $.ajax({
                        url: 'get_petani_data.php', // Create a new PHP file to handle this request
                        method: 'POST',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Populate the modal with the existing data
                            $('#modalEditPetani').find('.modal-body').html(data);
                            $('#modalEditPetani').modal('show');
                        }
                    });
                });
            });
        </script>

        <!-- MODAL HAPUS-->
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