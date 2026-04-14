<?php
$conn = mysqli_connect("localhost", "root", "", "user_system");
$ambil_data = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog | SportSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #000b14; color: white; background-image: linear-gradient(rgba(0,11,20,0.8), rgba(0,11,20,0.9)), url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=1920'); background-size: cover; background-attachment: fixed; }
        .sidebar { background: rgba(0, 15, 30, 0.95); min-height: 100vh; border-right: 1px solid rgba(255,255,255,0.1); }
        .nav-link { color: #a0aec0; padding: 12px 20px; border-radius: 14px; margin: 5px 15px; text-decoration: none; display: block; }
        .nav-link.active { background: linear-gradient(135deg, #00a8ff, #0066ff); color: #fff; }
        .product-card { background: rgba(255,255,255,0.08); border-radius: 20px; padding: 20px; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; transition: 0.3s; }
        .product-card:hover { transform: translateY(-10px); border-color: #00a8ff; }
        .modal-content { background: rgba(0, 15, 30, 0.95); border: 1px solid #00a8ff; color: white; border-radius: 20px; }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2 sidebar pt-4 text-center">
            <h3 class="fw-bold mb-5 text-info">MonnSport</h3>
            <nav>
                <a class="nav-link" href="dashboard.php"><i class="bi bi-cpu-fill me-2"></i> Dashboard</a>
                <a class="nav-link active" href="produk.php"><i class="bi bi-dribbble me-2"></i> Produk Sport</a>
            </nav>
        </div>
        <div class="col-md-10 p-5">
            <h1 class="fw-bold mb-5">Katalog Produk Sport</h1>
            <div class="row g-4">
                <?php while($row = mysqli_fetch_assoc($ambil_data)): ?>
                <div class="col-md-3">
                    <div class="product-card text-center" data-bs-toggle="modal" data-bs-target="#modal<?= $row['id'] ?>">
                        <i class="bi bi-trophy text-info fs-1"></i>
                        <h5 class="mt-3 fw-bold"><?= $row['nama_produk'] ?></h5>
                        <p class="text-info">Rp <?= number_format($row['harga']) ?></p>
                    </div>
                </div>

                <div class="modal fade" id="modal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-4 text-center">
                            <h2 class="fw-bold text-info"><?= $row['nama_produk'] ?></h2>
                            <hr>
                            <h4 class="mb-3">Harga: Rp <?= number_format($row['harga']) ?></h4>
                            <p class="fs-5">Stok Tersedia: <strong><?= $row['stok'] ?> Unit</strong></p>
                            <button class="btn btn-info mt-3" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>