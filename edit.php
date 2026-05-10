<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

if (isset($_POST['update'])) {
    $nim   = $_POST['nim'];
    $nama  = $_POST['nama'];
    $mk    = $_POST['mk'];
    $nilai = $_POST['nilai'];

    $update_stmt = $conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, mata_kuliah = ?, nilai = ? WHERE id = ?");
    $update_stmt->bind_param("sssii", $nim, $nama, $mk, $nilai, $id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Nilai Mahasiswa</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control" value="<?= htmlspecialchars($data['nim']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mata Kuliah</label>
                            <input type="text" name="mk" class="form-control" value="<?= htmlspecialchars($data['mata_kuliah']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nilai</label>
                            <input type="number" name="nilai" class="form-control" value="<?= $data['nilai']; ?>" min="0" max="100" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
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