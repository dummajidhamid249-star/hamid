<?php
// 1. KONEKSI DATABASE
$conn = mysqli_connect("localhost", "root", "", "user_system");

// 2. LOGIKA TAMBAH DATA (Jika tombol Simpan diklik)
if (isset($_POST['tambah'])) {
    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok  = $_POST['stok'];
    mysqli_query($conn, "INSERT INTO produk VALUES ('', '$nama', '$harga', '$stok')");
    header("Location: dashboard.php"); // Refresh halaman
}

// 3. LOGIKA HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM produk WHERE id=$id");
    header("Location: dashboard.php");
}

// 4. AMBIL DATA
$ambil_data = mysqli_query($conn, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Toko Hamid - Instan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5 bg-light">

<div class="container bg-white p-4 shadow-sm">
    <h2 class="mb-4">Dashboard Toko Sederhana</h2>

    <form method="POST" class="row g-3 mb-5 border-bottom pb-4">
        <div class="col-md-4">
            <input type="text" name="nama" class="form-control" placeholder="Nama Produk" required>
        </div>
        <div class="col-md-3">
            <input type="number" name="harga" class="form-control" placeholder="Harga (Rp)" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="stok" class="form-control" placeholder="Stok" required>
        </div>
        <div class="col-md-3">
            <button type="submit" name="tambah" class="btn btn-success w-100">Tambah Barang</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while($row = mysqli_fetch_assoc($ambil_data)) : ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td>Rp <?= number_format($row['harga']); ?></td>
                <td><?= $row['stok']; ?></td>
                <td>
                    <a href="dashboard.php?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>