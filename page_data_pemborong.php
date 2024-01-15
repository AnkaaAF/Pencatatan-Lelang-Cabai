<!-- Page pesanan -->
<h1 class="h3 mb-2 text-gray-800">Data Pemborong </h1>
<p class="mb-4"> Menampilkan Data Peserta Pemborong yang ada pada website<a class="text-info" target="_blank" href="../index.php" target="_blank"> Lelang Cabai</a>.</p>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">List Data Peserta Lelang Pemborong</h6>
    </div>

    <div class="card-body">

        <!-- TOMBOL TAMBAH -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalTambahPeserta">
                <i class="fas fa-fw fa-plus"></i> Tambah Data
            </button>
        </div>

        <!-- Tabel untuk Pemborong -->
        <h2 class="h3 mb-2 text-gray-800">Data Pemborong</h2>
        <table class="table table-bordered" id="dataTablePemborong" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NIK</th>
                    <th>Nama Pemborong</th>
                    <th>No Hp</th>
                    <th>Alamat</th>
                    <th>Edit</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $datasqlPemborong = mysqli_query($connect, "SELECT * FROM tb_data_peserta_lelang WHERE peran = 2");
                $no = 1;
                while ($dataPemborong = mysqli_fetch_array($datasqlPemborong)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $dataPemborong['nik'] ?></td>
                        <td><?= $dataPemborong['nama_peserta'] ?></td>
                        <td><?= $dataPemborong['no_hp'] ?></td>
                        <td><?= $dataPemborong['alamat'] ?></td>

                        <td> <a class="btn btn-warning btn-edit" data-toggle="modal" data-target="#modalEditPesertaPemborong<?= $dataPemborong["id"] ?>"><i class="bi bi-pencil"></i></a></td>
                        <td>
                            <a href="../admin/function/hapus_peserta_pemborong.php?id=<?= $dataPemborong['id']; ?>" class="btn btn-danger flash-hapus"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>

                    <!-- Modal Edit Pemborong -->
                    <div class="modal fade" id="modalEditPesertaPemborong<?= $dataPemborong["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditPesertaPemborongLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form action="../admin/function/edit_peserta_pemborong.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditPesertaPemborongLabel">Edit Data Pemborong</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Hidden input untuk menyimpan ID -->
                                        <input type="hidden" name="id" value="<?php echo $dataPemborong['id'] ?>">

                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <input type="text" name="nik" id="nik" class="form-control" value="<?php echo $dataPemborong['nik']; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_peserta">Nama Pemborong</label>
                                            <input type="text" name="nama_peserta" id="nama_peserta" class="form-control" value="<?php echo $dataPemborong['nama_peserta']; ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="no_hp">Nomor HP</label>
                                            <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?php echo $dataPemborong['no_hp']; ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control" required><?php echo $dataPemborong['alamat']; ?></textarea>
                                        </div>
                                        <div class="form-group hidden">
                                            <label for="">Peran</label>
                                            <select name="peran" id="" class="form-control">
                                                <option value="2">Pemborong</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="simpan_edit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>


        <!-- Modal -->
        <div class="modal fade" id="modalTambahPeserta" tabindex="-1" role="dialog" aria-labelledby="modalTambahPeserta" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="../admin/function/func_peserta_pemborong.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Data Peserta</h5>
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
                                    <option value="2">Pemborong</option>
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

        <!-- SCRIPT untuk Menyimpan ID dan Data di Modal Edit -->
        <script>
            $(document).ready(function() {
                $('.btn-edit').on('click', function() {
                    var id = $(this).data('id');
                    var nik = $(this).data('nik');
                    var nama_peserta = $(this).data('nama_peserta');
                    var no_hp = $(this).data('no_hp');
                    var alamat = $(this).data('alamat');

                    // Mengisi nilai input pada modal edit dengan data yang sesuai
                    $('#edit_id').val(id);
                    $('#edit_nik').val(nik);
                    $('#edit_nama_peserta').val(nama_peserta);
                    $('#edit_no_hp').val(no_hp);
                    $('#edit_alamat').val(alamat);

                    // Menampilkan modal edit
                    $('#modalEditPesertaPemborong').modal('show');
                });
            });
        </script>

        <!-- SCRIPT -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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