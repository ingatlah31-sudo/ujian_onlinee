<?php
session_start();

// Validasi user apakah benar murid
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'murid') {
    header("Location: ../auth/login.php");
    exit;
}

// Koneksi langsung database agar aman dari error path
$koneksi = mysqli_connect("localhost", "root", "", "ujian_online");

// Inisialisasi variabel awal skor
$jumlah_benar = 0;
$jumlah_salah = 0;
$nilai = 0;

// Logika menghitung nilai ketika tombol diklik
if (isset($_POST['kirim_ujian']) && isset($_POST['jawaban'])) {
    $jawaban_murid = $_POST['jawaban']; // Mengambil array jawaban yang dipilih murid

    foreach ($jawaban_murid as $id_soal => $jawaban_pilihan) {
        // Ambil kunci jawaban yang benar dari database berdasarkan ID soal
        $query_kunci = mysqli_query($koneksi, "SELECT jawaban_benar FROM soal WHERE id = '$id_soal'");
        $data_soal = mysqli_fetch_assoc($query_kunci);

        if ($data_soal) {
            // Cocokkan jawaban murid dengan database (ubah ke huruf besar semua agar adil)
            if (strtoupper($jawaban_pilihan) == strtoupper($data_soal['jawaban_benar'])) {
                $jumlah_benar++;
            } else {
                $jumlah_salah++;
            }
        }
    }

    // Hitung total soal yang dikerjakan
    $total_soal = $jumlah_benar + $jumlah_salah;
    
// Rumus Matematika menghitung Nilai Akhir (Skala 0 - 100)
    if ($total_soal > 0) {
        $nilai = round(($jumlah_benar / $total_soal) * 100);
    }

    // --- KODE BARU: MENYIMPAN HASIL UJIAN KE DATABASE ---
    // Mengambil ID Murid yang sedang login dari session
    $user_id = $_SESSION['id']; 
    
    // Perintah SQL untuk simpan ke tabel hasil_ujian sesuai dengan pedoman tugas
    $query_simpan = mysqli_query($koneksi, "INSERT INTO hasil_ujian (user_id, jumlah_benar, jumlah_salah, nilai) VALUES ('$user_id', '$jumlah_benar', '$jumlah_salah', '$nilai')");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Ujian Anda - Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">Ringkasan Hasil Ujian</h4>
                </div>
                <div class="card-body p-4">
                    <table class="table table-borderless fs-5">
                        <tr>
                            <td width="40%">Nama Siswa</td>
                            <td>: <strong><?= htmlspecialchars($_SESSION['nama']); ?></strong></td>
                        </tr>
                        <tr class="text-success">
                            <td>Jumlah Benar</td>
                            <td>: <strong><?= $jumlah_benar; ?></strong></td>
                        </tr>
                        <tr class="text-danger">
                            <td>Jumlah Salah</td>
                            <td>: <strong><?= $jumlah_salah; ?></strong></td>
                        </tr>
                    </table>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded border">
                        <span class="fs-4 fw-bold">Nilai Akhir</span>
                        <span class="badge bg-primary fs-4 px-4 py-2 shadow-sm"><?= $nilai; ?></span>
                    </div>

                    <div class="row mt-4 g-2">
                        <div class="col-6">
                            <a href="dashboard.php" class="btn btn-outline-secondary w-100 py-2">Kembali ke Dashboard</a>
                        </div>
                        <div class="col-6">
                            <a href="../auth/logout.php" class="btn btn-danger w-100 py-2">Keluar Aplikasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>