<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?pesan=hapus_berhasil");
    } else {
        echo "Gagal menghapus data: " . $conn->error;
    }
    $stmt->close();
} else {
    header("Location: index.php");
}
?>