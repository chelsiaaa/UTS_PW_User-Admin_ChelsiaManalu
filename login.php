<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php'; // Pastikan file ini mendefinisikan variabel koneksi $conn (mysqli object)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<p style='color:red; text-align:center;'>Email dan password wajib diisi!</p>";
    } else {
        
        // 1. Ganti SELECT * menjadi SELECT id, username, email, role, password (jika menggunakan hashing)
        // Jika Anda TIDAK menggunakan hashing, kolom password di query ini tidak perlu
        // Kita asumsikan Anda belum menggunakan password hashing (sesuai kode Anda sebelumnya)
        $stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE email = ? AND password = ?");
        
        // Cek jika statement berhasil dipersiapkan
        if ($stmt === false) {
             die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // 2. Tambahkan 'role' ke variabel sesi
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'] // ✅ KOLOM ROLE DITAMBAHKAN DI SINI
            ];

            // Admin bisa diarahkan ke dashboard, User ke home
$redirect_page = ($user['role'] === 'admin') ? 'dashboard' : 'home';
header("Location: index.php?page=$redirect_page");
exit;
        } else {
            echo "<p style='color:red; text-align:center;'>Email atau password salah!</p>";
        }
        $stmt->close();
    }
}
?>

<style>
    /* ... (CSS Anda tetap sama) ... */
    body {
        font-family: Arial, sans-serif;
        background-color: #f3f4f6;
        margin: 0;
        padding: 0;
    }

    .login-wrapper {
        width: 100%;
        background: #fff;
        padding: 40px 80px;
        box-sizing: border-box;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    form {
        width: 100%;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #444;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        margin-bottom: 15px;
    }

    button {
        width: 100%;
        background-color: #007bff;
        color: white;
        padding: 14px 0;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 5px;
    }

    button:hover {
        background-color: #0056b3;
    }

    p {
        text-align: left;
        margin-top: 15px;
        font-size: 14px;
    }

    a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .login-wrapper {
            padding: 30px 20px;
        }
    }
</style>

<div class="login-wrapper">
    <h2>Login</h2>

    <form method="post" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Masukkan email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Masukkan password" required>

        <button type="submit">Login</button>
    </form>
</div>