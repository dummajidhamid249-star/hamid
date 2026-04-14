<?php
// 1. KONEKSI DATABASE
$conn = mysqli_connect("localhost", "root", "", "user_system");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. LOGIKA TAMBAH PRODUK
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    mysqli_query($conn, "INSERT INTO produk (nama_produk, harga, stok) VALUES ('$nama', '$harga', '$stok')");
    header("Location: dashboard.php"); exit();
}

// 3. LOGIKA UPDATE PRODUK (FITUR BARU)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    mysqli_query($conn, "UPDATE produk SET nama_produk='$nama', harga='$harga', stok='$stok' WHERE id=$id");
    header("Location: dashboard.php"); exit();
}

// 4. LOGIKA HAPUS PRODUK
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM produk WHERE id=$id");
    header("Location: dashboard.php"); exit();
}

// 5. LOGIKA AMBIL DATA UNTUK EDIT (Menampilkan data di form)
$data_edit = null;
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $result_edit = mysqli_query($conn, "SELECT * FROM produk WHERE id=$id_edit");
    $data_edit = mysqli_fetch_assoc($result_edit);
}

// 6. AMBIL DATA UNTUK TABEL & STATISTIK
$ambil_produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
$total_produk = mysqli_num_rows($ambil_produk);

$ambil_admin = mysqli_query($conn, "SELECT id FROM admins");
$total_admin = ($ambil_admin) ? mysqli_num_rows($ambil_admin) : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | SportSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --sky-blue: #00a8ff; --glass: rgba(255, 255, 255, 0.08); }
        body { 
            background: #000b14; color: white;
            background-image: linear-gradient(rgba(0,11,20,0.8), rgba(0,11,20,0.9)), url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=1920');
            background-size: cover; background-attachment: fixed;
        }
        .sidebar { background: rgba(0, 15, 30, 0.95); min-height: 100vh; border-right: 1px solid rgba(255,255,255,0.1); }
        .nav-link { color: #a0aec0; padding: 12px 20px; border-radius: 14px; margin: 5px 15px; display: block; text-decoration: none; }
        .nav-link.active, .nav-link:hover { background: linear-gradient(135deg, #00a8ff, #0066ff); color: white; }
        .luxury-card { background: var(--glass); border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 25px; backdrop-filter: blur(15px); }
        .stat-icon { font-size: 2rem; color: var(--sky-blue); }
        .form-control { background: rgba(255,255,255,0.1); border: 1px solid rgba(0,168,255,0.3); color: white; }
        .form-control:focus { background: rgba(255,255,255,0.15); border-color: var(--sky-blue); color: white; box-shadow: none; }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar pt-4 text-center">
            <h3 class="fw-bold mb-5 text-info">MonnSport</h3>
            <nav>
                <a class="nav-link active" href="dashboard.php"><i class="bi bi-cpu-fill me-2"></i> Dashboard</a>
                <a class="nav-link" href="produk.php"><i class="bi bi-dribbble me-2"></i> Produk Sport</a>
                <a class="nav-link" href="admin.php"><i class="bi bi-person-gear me-2"></i> Admin Panel</a>
                <a class="nav-link text-danger mt-5" href="logout.php">Log Out</a>
            </nav>
        </div>

        <div class="col-md-10 p-5">
            <h1 class="fw-bold mb-5">Control Center</h1>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="luxury-card d-flex align-items-center gap-4">
                        <div class="stat-icon"><i class="bi bi-trophy-fill"></i></div>
                        <div>
                            <div class="small text-white-50">TOTAL PRODUK</div>
                            <div class="fw-bold fs-3"><?= $total_produk; ?> Items</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="luxury-card d-flex align-items-center gap-4">
                        <div class="stat-icon text-warning"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <div class="small text-white-50">ADMIN AKTIF</div>
                            <div class="fw-bold fs-3"><?= $total_admin; ?> Users</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="admin.php" class="text-decoration-none">
                        <div class="luxury-card d-flex align-items-center gap-4 border-info">
                            <div class="stat-icon text-info"><i class="bi bi-gear-fill"></i></div>
                            <div class="text-white">
                                <div class="small text-white-50">PENGATURAN</div>
                                <div class="fw-bold">Buka Admin Panel <i class="bi bi-arrow-right"></i></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="luxury-card mb-4">
                <h5 class="mb-4 text-info">
                    <?= $data_edit ? 'Edit Produk: ' . $data_edit['nama_produk'] : 'Tambah Inventaris Baru' ?>
                </h5>
                <form method="POST" class="row g-3">
                    <?php if ($data_edit): ?>
                        <input type="hidden" name="id" value="<?= $data_edit['id']; ?>">
                    <?php endif; ?>

                    <div class="col-md-5">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Produk" 
                               value="<?= $data_edit ? $data_edit['nama_produk'] : '' ?>" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="harga" class="form-control" placeholder="Harga" 
                               value="<?= $data_edit ? $data_edit['harga'] : '' ?>" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="stok" class="form-control" placeholder="Stok" 
                               value="<?= $data_edit ? $data_edit['stok'] : '' ?>" required>
                    </div>
                    <div class="col-md-2">
                        <?php if ($data_edit): ?>
                            <button type="submit" name="update" class="btn btn-warning w-100 fw-bold">UPDATE</button>
                            <a href="dashboard.php" class="btn btn-sm btn-link text-white d-block text-center">Batal</a>
                        <?php else: ?>
                            <button type="submit" name="tambah" class="btn btn-info w-100 fw-bold">SIMPAN</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="luxury-card">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($ambil_produk)) : ?>
                        <tr>
                            <td><?= $row['nama_produk']; ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?= $row['stok']; ?> Unit</td>
                            <td class="text-center">
                                <a href="dashboard.php?edit=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info me-2">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="dashboard.php?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    <i class="bi bi-trash"></i> Hapus
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

</body>
</html>