<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        echo "<p style='color:red; text-align:center;'>Semua kolom wajib diisi!</p>";
    } else {
        
        $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "<p style='color:red; text-align:center;'>Email sudah terdaftar! Gunakan email lain.</p>";
        } else {
            
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                echo "<p style='color:green; text-align:center;'>Registrasi berhasil! Silakan login.</p>";
                echo "<meta http-equiv='refresh' content='2;url=index.php?page=login'>";
            } else {
                echo "<p style='color:red; text-align:center;'>Terjadi kesalahan saat menyimpan data.</p>";
            }
        }
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f3f4f6;
        margin: 0;
        padding: 0;
    }

    .register-wrapper {
    width: 400px;                /* batasi lebar kotak */
    margin: 80px auto;           /* biar di tengah layar */
    background: #fff;
    padding: 40px;
    border-radius: 10px;         /* sudut melengkung */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* efek bayangan halus */
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

    input[type="text"],
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
        .register-wrapper {
            padding: 30px 20px;
        }
    }
</style>

<div class="register-wrapper">
    <h2>Register</h2>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Masukkan username" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Masukkan email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Masukkan password" required>

        <button type="submit">Daftar</button>
    </form>

</div>