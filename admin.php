<?php
// 1. KONEKSI DATABASE
$conn = mysqli_connect("localhost", "root", "", "user_system");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. LOGIKA TAMBAH ADMIN
if (isset($_POST['tambah_admin'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $role = $_POST['role'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO admins (username, password, nama_lengkap, role) VALUES ('$user', '$pass', '$nama', '$role')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: admin.php?status=success");
    } else {
        header("Location: admin.php?status=error");
    }
    exit();
}

// 3. LOGIKA HAPUS ADMIN
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM admins WHERE id=$id");
    header("Location: admin.php");
    exit();
}

// 4. AMBIL DATA ADMIN
$ambil_admin = mysqli_query($conn, "SELECT * FROM admins ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | SportSphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sky-blue: #00a8ff;
            --glass: rgba(255, 255, 255, 0.08);
            --sidebar-dark: rgba(0, 15, 30, 0.95);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #000b14; color: white; 
            background-image: linear-gradient(rgba(0,11,20,0.8), rgba(0,11,20,0.9)), 
                              url('https://images.unsplash.com/photo-1552674605-db6ffd4facb5?q=80&w=1920');
            background-size: cover; background-attachment: fixed;
        }

        .sidebar { background: var(--sidebar-dark); backdrop-filter: blur(20px); min-height: 100vh; border-right: 1px solid rgba(255,255,255,0.1); }
        
        .nav-link { 
            color: #a0aec0; padding: 12px 20px; border-radius: 14px; margin: 5px 15px; 
            text-decoration: none; display: flex; align-items: center; transition: 0.3s; 
        }

        .nav-link:hover, .nav-link.active { background: linear-gradient(135deg, #00a8ff, #0066ff); color: #fff; }

        .luxury-card { 
            background: var(--glass); border: 1px solid rgba(255,255,255,0.1); 
            border-radius: 24px; padding: 30px; backdrop-filter: blur(15px); 
        }

        .form-control, .form-select { 
            background: rgba(255,255,255,0.05); border: 1px solid rgba(0, 168, 255, 0.3); 
            color: white; border-radius: 12px; padding: 12px;
        }

        .form-control:focus { background: rgba(255,255,255,0.1); border-color: var(--sky-blue); color: white; box-shadow: 0 0 15px rgba(0, 168, 255, 0.4); }

        .btn-info { background: linear-gradient(135deg, #00d2ff, #00a8ff); border: none; font-weight: 700; border-radius: 12px; }
        
        .messi-title { text-shadow: 0 0 20px rgba(0, 168, 255, 0.5); font-weight: 800; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-3 col-lg-2 sidebar pt-4 text-center d-none d-md-block">
            <h3 class="messi-title mb-5 text-info">Monn<span class="text-white">Sport</span></h3>
            <nav>
                <a class="nav-link" href="dashboard.php"><i class="bi bi-cpu-fill me-3"></i> Dashboard</a>
                <a class="nav-link" href="produk.php"><i class="bi bi-dribbble me-3"></i> Produk Sport</a>
                <a class="nav-link active" href="admin.php"><i class="bi bi-person-gear me-3"></i> Admin Panel</a>
                <a class="nav-link text-danger mt-5" href="logout.php"><i class="bi bi-box-arrow-left me-3"></i> Log Out</a>
            </nav>
        </div>

        <div class="col-md-9 col-lg-10 p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="fw-bold messi-title"><i class="bi bi-shield-lock-fill text-info me-3"></i>User Management</h1>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="luxury-card">
                        <h5 class="mb-4 fw-bold text-info"><i class="bi bi-person-plus-fill me-2"></i>Registrasi Admin</h5>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="small text-white-50 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Remon" required>
                            </div>
                            <div class="mb-3">
                                <label class="small text-white-50 mb-2">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Untuk Login" required>
                            </div>
                            <div class="mb-3">
                                <label class="small text-white-50 mb-2">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Min. 6 Karakter" required>
                            </div>
                            <div class="mb-4">
                                <label class="small text-white-50 mb-2">Role Akses</label>
                                <select name="role" class="form-select">
                                    <option value="Editor">Editor (Stok Only)</option>
                                    <option value="Super Admin">Super Admin (Full Access)</option>
                                </select>
                            </div>
                            <button type="submit" name="tambah_admin" class="btn btn-info w-100 py-3">DAFTARKAN ADMIN</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="luxury-card">
                        <h5 class="mb-4 fw-bold"><i class="bi bi-people-fill text-info me-2"></i>Daftar Pengguna Sistem</h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead>
                                    <tr class="text-info opacity-75">
                                        <th>PENGGUNA</th>
                                        <th>HAK AKSES</th>
                                        <th class="text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($ambil_admin)) : ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?= htmlspecialchars($row['nama_lengkap']); ?></div>
                                            <small class="text-white-50">@<?= htmlspecialchars($row['username']); ?></small>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill <?= $row['role'] == 'Super Admin' ? 'bg-info' : 'bg-secondary' ?> px-3">
                                                <?= $row['role']; ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="admin.php?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus akses admin ini?')">
                                                <i class="bi bi-trash3-fill fs-5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>