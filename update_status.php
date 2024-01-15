<?php
// Sambungkan ke database
include_once("../config/database.php");

// Periksa apakah parameter 'id' telah diterima dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data dari database berdasarkan ID
    $query = "SELECT * FROM tb_pelelangan_petani WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $status_pembayaran = $row['status_pembayaran'];

        // Ubah status pembayaran (contoh: toggle antara 'Terbayar' dan 'Belum Terbayar')
        if ($status_pembayaran == 'Terbayar') {
            $new_status = 'Belum Terbayar';
        } else {
            $new_status = 'Terbayar';
        }

        // Update status pembayaran dalam database
        $update_query = "UPDATE tb_pelelangan_pemborong SET status_pembayaran = '$new_status' WHERE id = $id";
        if (mysqli_query($koneksi, $update_query)) {
            // Jika berhasil diupdate, redirect kembali ke halaman sebelumnya
            header("Location: page_hasil_lelang_petani.php");
            exit();
        } else {
            $error_message = "Gagal mengupdate status pembayaran: " . mysqli_error($koneksi);
        }
    } else {
        $error_message = "Data tidak ditemukan.";
    }
} else {
    $error_message = "ID tidak ditemukan dalam parameter URL.";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <h1>Error</h1>
    <p><?php echo $error_message; ?></p>
    <a href="page_hasil_lelang_petani.php">Kembali</a>
</body>
</html>
