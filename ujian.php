<?php
session_start();

// Validasi user apakah benar murid
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'murid') {
    header("Location: ../auth/login.php");
    exit;
}

// Koneksi langsung database agar aman dari error path
$koneksi = mysqli_connect("localhost", "root", "", "ujian_online");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data soal ujian dari database
$query = mysqli_query($koneksi, "SELECT * FROM soal");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Ujian - Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Ujian Online - Panel Murid</a>
        <span class="navbar-text text-white">Nama Siswa: <strong><?= $_SESSION['nama']; ?></strong></span>
    </div>
</nav>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Lembar Soal Ujian</h4>
                </div>
                <div class="card-body">
                    <form action="hasil.php" method="POST">
                        <?php 
                        $no = 1;
                        if (mysqli_num_rows($query) > 0) {
                            // Di sini kita gunakan $row agar kompak dengan baris bawahnya
                            while($row = mysqli_fetch_assoc($query)) { 
                        ?>
                            <div class="mb-4 border-bottom pb-3">
                                <p class="fw-bold"><?= $no++; ?>. <?= htmlspecialchars($row['pertanyaan']); ?></p>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="jawaban[<?= $row['id']; ?>]" value="A" id="q_<?= $row['id']; ?>_A" required>
                                    <label class="form-check-label" for="q_<?= $row['id']; ?>_A">A. <?= htmlspecialchars($row['pilihan_a']); ?></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="jawaban[<?= $row['id']; ?>]" value="B" id="q_<?= $row['id']; ?>_B">
                                    <label class="form-check-label" for="q_<?= $row['id']; ?>_B">B. <?= htmlspecialchars($row['pilihan_b']); ?></label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="jawaban[<?= $row['id']; ?>]" value="C" id="q_<?= $row['id']; ?>_C">
                                    <label class="form-check-label" for="q_<?= $row['id']; ?>_C">C. <?= htmlspecialchars($row['pilihan_c']); ?></label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="jawaban[<?= $row['id']; ?>]" value="D" id="q_<?= $row['id']; ?>_D">
                                    <label class="form-check-label" for="q_<?= $row['id']; ?>_D">D. <?= htmlspecialchars($row['pilihan_d']); ?></label>
                                </div>
                            </div>
                        <?php 
                            }
                        } else {
                            echo "<div class='alert alert-warning text-center'>Belum ada soal ujian yang tersedia. Silakan hubungi Guru Anda!</div>";
                        }
                        ?>
                        
                        <?php if (mysqli_num_rows($query) > 0): ?>
                            <button type="submit" name="kirim_ujian" class="btn btn-success w-100 btn-lg shadow-sm mt-3">Kirim Semua Jawaban</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>