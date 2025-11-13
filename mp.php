<?php
include "koneksi.php";

// 🔹 Data produk awal
$produk = [
    ["id" => 100, "nama_produk" => "Quaker Oatmeal Instan 800g", "harga" => 54900, "stok" => 30, "supplier" => "PT Jaya Utama Santikah"],
    ["id" => 101, "nama_produk" => "Kitkat Sereal Cokelat Box 330g", "harga" => 49900, "stok" => 25, "supplier" => "PT Nestlé Indonesia"],
    ["id" => 102, "nama_produk" => "Molto Pewangi Pakaian", "harga" => 39000, "stok" => 40, "supplier" => "PT indah Jaya Indonesia"],
    ["id" => 104, "nama_produk" => "Monitor Samsung 24 inch", "harga" => 2000000, "stok" => 8, "supplier" => "Samsung Indonesia"],
];

// 🔹 Pastikan tabel produk sudah ada
$cek_tabel = mysqli_query($conn, "SHOW TABLES LIKE 'produk'");
if (mysqli_num_rows($cek_tabel) == 0) {
    $buat_tabel = "
        CREATE TABLE produk (
            id INT PRIMARY KEY,
            nama_produk VARCHAR(100),
            harga INT,
            stok INT,
            supplier VARCHAR(100)
        )
    ";
    mysqli_query($conn, $buat_tabel);
}

// 🔹 Cek dan masukkan data hanya jika belum ada
foreach ($produk as $p) {
    $id = $p['id'];
    $nama = mysqli_real_escape_string($conn, $p['nama_produk']);
    $harga = $p['harga'];
    $stok = $p['stok'];
    $supplier = mysqli_real_escape_string($conn, $p['supplier']);

    $cek = mysqli_query($conn, "SELECT id FROM produk WHERE id='$id'");
    if ($cek && mysqli_num_rows($cek) == 0) {
        $insert = mysqli_query($conn, "
            INSERT INTO produk (id, nama_produk, harga, stok, supplier)
            VALUES ('$id', '$nama', '$harga', '$stok', '$supplier')
        ");
    }
}
?>

<div class="card" style="
    width: 80%;
    margin: 40px auto;
    padding: 30px;
    border-radius: 15px;
    background-color: white;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
">
    <h2 style="text-align:center; color:#333; margin-bottom:20px;">
        Master Product
    </h2>

    <table style="
        width: 100%;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    ">
        <thead>
            <tr style="background-color:#007bff; color:white; text-align:left;">
                <th style="padding:12px;">ID</th>
                <th style="padding:12px;">Nama Produk</th>
                <th style="padding:12px;">Harga</th>
                <th style="padding:12px;">Stok</th>
                <th style="padding:12px;">Supplier</th>
                <th style="padding:12px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id ASC");
            if ($query && mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
                    echo "<tr style='border-bottom:1px solid #ddd;'>";
                    echo "<td style='padding:10px;'>{$data['id']}</td>";
                    echo "<td style='padding:10px;'>{$data['nama_produk']}</td>";
                    echo "<td style='padding:10px;'>Rp " . number_format($data['harga'], 0, ',', '.') . "</td>";
                    echo "<td style='padding:10px;'>{$data['stok']}</td>";
                    echo "<td style='padding:10px;'>{$data['supplier']}</td>";
                    echo "<td style='padding:10px;'>
                            <a href='#' style='color:#007bff; text-decoration:none; font-weight:bold;'>Edit</a> | 
                            <a href='#' style='color:#dc3545; text-decoration:none; font-weight:bold;'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center; padding:15px;'>Tidak ada data produk.</td></tr>";
            }
            ?>
        </tbody>
    </table>

        <!-- 🔸 Tombol Tambah Produk di bawah kiri -->
    <div style="text-align:left; margin-top:20px;">
        <a href="tambahkan produk.php" 
           style="
               background-color:#007bff; 
               color:white; 
               padding:10px 15px; 
               border-radius:8px; 
               text-decoration:none; 
               font-weight:bold; 
               display:inline-flex; 
               align-items:center;
               gap:8px;
               box-shadow:0 2px 6px rgba(0,0,0,0.1);
               transition:background-color 0.3s, transform 0.1s;
           "
           onmouseover="this.style.backgroundColor='#0056b3';"
           onmouseout="this.style.backgroundColor='#007bff';"
           onmousedown="this.style.backgroundColor='#0069d9'; this.style.transform='scale(0.97)';"
           onmouseup="this.style.backgroundColor='#0056b3'; this.style.transform='scale(1)';"
        >
            <span style="
                display:inline-block;
                background-color:white;
                color:#007bff;
                border-radius:50%;
                width:22px;
                height:22px;
                line-height:22px;
                text-align:center;
                font-weight:bold;
                font-size:14px;
            ">+</span>
            Tambahkan Produk
        </a>
    </div>
</div>
