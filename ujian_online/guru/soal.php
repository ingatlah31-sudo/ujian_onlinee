<?php
session_start();
if($_SESSION['role'] != 'guru') {
    header("Location: ../auth/login.php");
    exit;
}

// Langsung panggil koneksi database di sini
$koneksi = mysqli_connect("localhost", "root", "", "ujian_online");

// Mengambil seluruh data soal dari database
$query = mysqli_query($koneksi, "SELECT * FROM soal");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Soal - Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Soal Ujian</h2>
        <div>
            <a href="dashboard.php" class="btn btn-secondary btn-sm">Kembali</a>
            <a href="tambah_soal.php" class="btn btn-primary btn-sm">+ Tambah Soal</a>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Pertanyaan</th>
                        <th width="10%">A</th>
                        <th width="10%">B</th>
                        <th width="10%">C</th>
                        <th width="10%">D</th>
                        <th width="8%">Kunci</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    if(mysqli_num_rows($query) == 0): 
                    ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">Belum ada soal kuis. Silakan tambah soal baru!</td>
                        </tr>
                    <?php 
                    else:
                        while($row = mysqli_fetch_assoc($query)): 
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['pertanyaan']); ?></td>
                            <td><?= htmlspecialchars($row['pilihan_a']); ?></td>
                            <td><?= htmlspecialchars($row['pilihan_b']); ?></td>
                            <td><?= htmlspecialchars($row['pilihan_c']); ?></td>
                            <td><?= htmlspecialchars($row['pilihan_d']); ?></td>
                            <td class="text-center fw-bold text-success"><?= $row['jawaban_benar']; ?></td>
                            <td class="text-center">
                                <a href="edit_soal.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus_soal.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php 
                        endwhile; 
                    endif; 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>