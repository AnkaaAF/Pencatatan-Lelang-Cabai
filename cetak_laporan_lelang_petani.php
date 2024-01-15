<?php
 include('../config/database.php'); //sambungkan ke database

 $hari_tanggal = $_POST['tanggal'];
?>

<html>

<head>
    <figure class="text-center">
    <blockquote class="blockquote">
        <p></p>
    </blockquote>
    <div class="sidebar-brand-icon">
        <img class="logo" src="../images/logo-full-barukuning.png" alt="" width="200px">
    </div>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <style>
        .tanggal {
            border:1px solid #000;
            width:100%;
            padding:7px;
            font-weight: bold;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Button trigger modal -->
        <div class="row">
            <button type="button" class="btn btn-info ml-3" data-toggle="modal" data-target="#Telegram">
                <i class="fa fa-share-alt"></i> Telegram

            </button>
        </div>

        <div class="tanggal my-2">
            <?= date('l, d F Y', strtotime($hari_tanggal)) ?>
        </div>
        

        <!-- Modal -->
        <div class="modal fade" id="Telegram" tabindex="-1" role="dialog" aria-labelledby="TelegramLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="https://lelangcabai.my.id/function/telegram.php" method="POST" class="modal-content" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TelegramLabel">Upload file pelelangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <label class="custom-file-label" for="inputGroupFile01">Pilih File</label>
                                <input type="file" class="custom-file-input" name="in_file_pdf" id="inputGroupFile01" accept="application/pdf" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="_submit_" class="btn btn-primary">KIRIM</button>
                    </div>
                </form>
            </div>
        </div>

        <br />
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Hari, Tanggal</th>
                        <th>Jenis Cabai</th>
                        <th>Nama Petani</th>
                        <th>Total Cabai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $datasql = mysqli_query($connect, "SELECT tb_pelelangan_petani.*, tb_data_peserta_lelang.nik, tb_data_peserta_lelang.nama_peserta FROM tb_pelelangan_petani JOIN tb_data_peserta_lelang ON tb_pelelangan_petani.id_petani = tb_data_peserta_lelang.id WHERE tb_pelelangan_petani.hari_tanggal='$hari_tanggal'");
                        $no = 1;
                        while($data = mysqli_fetch_array($datasql)) { 
                    ?>
                    <tr>
                        <td> <?= $no++ ?></td>
                        <td> <?= date('l, d F Y', strtotime($data['hari_tanggal'])) ?></td>
                        <td> <?= $data['tipe_cabai'] ?></td>
                        <td> <?= $data['nama_peserta'] ?></td>
                        <td> <?= $data['jumlah_stor'] ?> Kg</td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
               //  dom: 'Bfrtip',
                // buttons: [
               //      'copy', 'csv', 'excel', 'pdf', 'print'
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
</body>
</html>