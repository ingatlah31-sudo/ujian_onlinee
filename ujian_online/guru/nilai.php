<?php
session_start();
if($_SESSION['role'] != 'guru') {
    header("Location: ../auth/login.php");
    exit;
}
$koneksi = mysqli_connect("localhost", "root", "", "ujian_online");

// Query SQL dengan INNER JOIN untuk merelasikan tabel hasil_ujian dan tabel users
$query = mysqli_query($koneksi, "SELECT hasil_ujian.*, users.nama FROM hasil_ujian INNER JOIN users ON hasil_ujian.user_id = users.id ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai Siswa - Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Guru Panel</a>
    <div class="navbar-nav">
      <a class="nav-link" href="dashboard.php">Dashboard</a>
      <a class="nav-link" href="soal.php">Kelola Soal</a>
      <a class="nav-link active" href="nilai.php">Lihat Nilai</a>
      <a class="nav-link text-danger" href="../auth/logout.php">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Perolehan Nilai Murid</h2>
        <a href="dashboard.php" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Murid</th>
                        <th width="15%">Jumlah Benar</th>
                        <th width="15%">Jumlah Salah</th>
                        <th width="15%">Nilai Akhir</th>
                        <th width="20%">Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    if(mysqli_num_rows($query) == 0): 
                    ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Belum ada murid yang mengerjakan ujian.</td>
                        </tr>
                    <?php 
                    else:
                        while($row = mysqli_fetch_assoc($query)): 
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><b><?= htmlspecialchars($row['nama']); ?></b></td>
                            <td class="text-center text-success fw-bold"><?= $row['jumlah_benar']; ?></td>
                            <td class="text-center text-danger"><?= $row['jumlah_salah']; ?></td>
                            <td class="text-center fw-bold fs-5 text-primary"><?= $row['nilai']; ?></td>
                            <td class="text-center text-muted"><?= $row['tanggal']; ?></td>
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