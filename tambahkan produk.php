<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: mp.php');
    exit;
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $expired_date = $_POST['expired_date'];

    $query = mysqli_query($conn, "INSERT INTO products (nama, kategori, harga, stok, expired_date)
                                  VALUES ('$nama', '$kategori', '$harga', '$stok', '$expired_date')");

    if ($query) {
        echo "<script>alert('Produk berhasil ditambahkan!'); window.location='dashboard_admin.php?page=product';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan produk!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Tambah Produk</h2>
    <form method="POST">
        <label>Nama Produk</label>
        <input type="text" name="nama" required>

        <label>Kategori</label>
        <input type="text" name="kategori" required>

        <label>Harga</label>
        <input type="number" name="harga" required>

        <label>Stok</label>
        <input type="number" name="stok" required>

        <label>Expired Date</label>
        <input type="date" name="expired_date" required>

        <button type="submit" name="submit">Tambah Produk</button>
    </form>
</div>
</body>
</html>