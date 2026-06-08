<?php
session_start();
// Memastikan hanya user dengan role murid yang bisa mengakses
if($_SESSION['role'] != 'murid') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Murid - Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 text-center" style="max-width: 600px;">
    <div class="card p-5 shadow border-0">
        <h3 class="mb-3">Selamat Datang, <b><?= htmlspecialchars($_SESSION['nama']); ?></b>! 🎓</h3>
        <p class="text-muted">Anda telah login ke sistem ujian online. Pastikan persiapan dan koneksi internet Anda stabil sebelum menekan tombol mulai di bawah ini.</p>
        <div class="mt-4">
            <a href="ujian.php" class="btn btn-lg btn-success px-5 shadow-sm">Mulai Ujian</a>
            <a href="../auth/logout.php" class="btn btn-lg btn-outline-danger px-4 ms-2">Logout</a>
        </div>
    </div>
</div>
</body>
</html>