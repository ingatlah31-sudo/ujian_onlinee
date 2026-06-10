<?php
session_start();
if($_SESSION['role'] != 'guru') {
    header("Location: ../auth/login.php");
    exit;
}
$koneksi = mysqli_connect("localhost", "root", "", "ujian_online");

if(isset($_POST['simpan'])) {
    // Mengambil data dari form input
    $pertanyaan = mysqli_real_escape_string($koneksi, $_POST['pertanyaan']);
    $a = mysqli_real_escape_string($koneksi, $_POST['pilihan_a']);
    $b = mysqli_real_escape_string($koneksi, $_POST['pilihan_b']);
    $c = mysqli_real_escape_string($koneksi, $_POST['pilihan_c']);
    $d = mysqli_real_escape_string($koneksi, $_POST['pilihan_d']);
    $kunci = $_POST['jawaban_benar'];

    // Query Insert data ke tabel soal
    $sql = "INSERT INTO soal (pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban_benar) 
            VALUES ('$pertanyaan', '$a', '$b', '$c', '$d', '$kunci')";
            
    if(mysqli_query($koneksi, $sql)) {
        header("Location: soal.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Soal - Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4 mb-5" style="max-width: 700px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Soal Baru</h4>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="pertanyaan" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilihan A</label>
                    <input type="text" name="pilihan_a" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilihan B</label>
                    <input type="text" name="pilihan_b" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilihan C</label>
                    <input type="text" name="pilihan_c" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilihan D</label>
                    <input type="text" name="pilihan_d" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jawaban Benar</label>
                    <select name="jawaban_benar" class="form-select" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
                <button type="submit" name="simpan" class="btn btn-success">Simpan Soal</button>
                <a href="soal.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>