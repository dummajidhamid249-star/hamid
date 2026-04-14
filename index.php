<?php
require_once 'config.php';
session_start();

$error = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Prepared Statement tetap sama (lebih aman)
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // 2. VERIFIKASI KHUSUS MD5
        // Kita ubah inputan user menjadi md5, lalu bandingkan dengan yang ada di DB
        if (md5($password) === $user['password']) {
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Modern SportSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0a0f1d; color: white; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); padding: 40px; border-radius: 20px; width: 100%; max-width: 400px; }
        .form-control { background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); color: white; }
        .form-control:focus { background: rgba(0,0,0,0.3); color: white; border-color: #00d2ff; box-shadow: none; }
        .btn-sport { background: linear-gradient(135deg, #00d2ff, #3a7bd5); border: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="login-card shadow-lg">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-info">SPORT<span class="text-white">SPHERE</span></h3>
        <p class="text-white-50 small">Sign in to Athlete Pro Dashboard</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2 small border-0 text-center" style="background: rgba(255,71,87,0.1); color: #ff4757;">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="small text-white-50">Username</label>
            <input type="text" name="username" class="form-control py-2" required autocomplete="off">
        </div>
        <div class="mb-4">
            <label class="small text-white-50">Password</label>
            <input type="password" name="password" class="form-control py-2" required>
        </div>
        <button type="submit" name="login" class="btn btn-sport w-100 py-2 text-white shadow">
            LOGIN SYSTEM
        </button>
    </form>
</div>

</body>
</html>