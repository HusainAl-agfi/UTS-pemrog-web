<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $nim   = $_POST['nim'];
    $nama  = $_POST['nama'];
    $mk    = $_POST['mk'];
    $nilai = $_POST['nilai'];

    $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, mata_kuliah, nilai) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nim, $nama, $mk, $nilai);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Tambah Nilai Mahasiswa</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control"
                             placeholder="Contoh: 12241965" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <input type="text" name="mk" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nilai</label>
                            <input type="number" name="nilai" class="form-control" min="0" max="100" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
                            <a href="index.php" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>