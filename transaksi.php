<?php
session_start();
include 'koneksi.php';

// Reset keranjang
if(isset($_GET['reset'])){
    $_SESSION['keranjang'] = [];
    header("Location: transaksi.php");
    exit;
}

// Inisialisasi keranjang
if(!isset($_SESSION['keranjang'])){
    $_SESSION['keranjang'] = [];
}

// Tambah ke keranjang
if(isset($_POST['tambah'])){
    $id = $_POST['barang'];
    $jumlah = $_POST['jumlah'];

    if($id != "" && $jumlah > 0){
        $_SESSION['keranjang'][] = [
            'id_barang' => $id,
            'jumlah' => $jumlah
        ];
        header("Location: transaksi.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Digital - Koperasi Babussalam</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #3b7064; color: #32847c; }
        .header-section { background: #a8ebac; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); border: 1px solid #ffffff; }
        .logo-box { background-color: #e2f300; padding: 8px; border-radius: 4px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; }
        .card-custom { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .btn-custom-nav { padding: 10px 20px; border-radius: 10px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; transition: 0.3s; border: none; color: white !important; }
        .btn-back { background-color: #2ecc71; }
        .btn-back:hover { background-color: #27ae60; }
        .btn-reset { background-color: #e74c3c; }
        .form-label { color: #94a3b8; font-size: 0.85rem; font-weight: 600; }
        .table thead th { background-color: #f8f9fa; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; padding: 15px; }
        .btn-save { background-color: #2ecc71; border: none; padding: 15px; font-weight: 700; width: 100%; border-radius: 8px; text-transform: uppercase; color: white; }
        /* Perbaikan tinggi kotak Select2 agar pas dengan Bootstrap */
        .select2-container--default .select2-selection--single { height: 38px !important; border: 1px solid #dee2e6 !important; padding: 5px !important; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="header-section d-flex align-items-center mb-4">
        <div class="logo-box me-3">
             <img src="logo.png" alt="Logo" style="width: 100%; height: auto;">
        </div>
        <div>
            <h4 class="m-0 fw-bold text-success">Koperasi Babussalam Selayar</h4>
            <p class="m-0 fw-bold small" style="color: #1b0b5e;">Sistem Transaksi Digital</p>
        </div>
    </div>

    <div class="mb-4 d-flex gap-2">
        <a href="index.php" class="btn-custom-nav btn-back shadow-sm"><i class="fa fa-arrow-left me-2"></i> Kembali ke Data Barang</a>
        <a href="?reset=true" class="btn-custom-nav btn-reset shadow-sm" onclick="return confirm('Reset keranjang?')"><i class="fa fa-trash me-2"></i> Reset Keranjang</a>
    </div>

    <div class="card-custom mb-4">
        <form method="post" class="row align-items-end g-3">
            <div class="col-md-5">
                <label class="form-label">Cari Nama Barang</label>
                <select name="barang" id="pilih_barang_keren" class="form-select" required>
                    <option value="">-- Ketik nama barang... --</option>
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM barang");
                    while($d = mysqli_fetch_array($data)){
                        echo "<option value='".$d['id_barang']."'>".$d['nama_barang']." (Stok: ".$d['stok'].")</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" value="1" min="1">
            </div>
            <div class="col-md-4">
                <button type="submit" name="tambah" class="btn btn-primary w-100 fw-bold" style="height: 38px;">ENTER</button>
            </div>
        </form>
    </div>

    <div class="card-custom p-0 overflow-hidden shadow-sm">
        <div class="p-4"><h6 class="fw-bold m-0"><i class="fa fa-shopping-cart me-2"></i>Keranjang Belanja</h6></div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">NAMA BARANG</th>
                        <th class="text-center">JUMLAH</th>
                        <th class="text-end pe-4">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach($_SESSION['keranjang'] as $item){
                        $id = $item['id_barang'];
                        $jumlah = $item['jumlah'];
                        $q = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id'");
                        $barang = mysqli_fetch_array($q);
                        if($barang){
                            $subtotal = $barang['harga'] * $jumlah;
                            $total += $subtotal;
                    ?>
                    <tr>
                        <td class="ps-4"><?php echo $barang['nama_barang']; ?></td>
                        <td class="text-center"><?php echo $jumlah; ?></td>
                        <td class="text-end pe-4 fw-bold">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    </tr>
                    <?php }} ?>
                    <tr style="background-color: #fffbeb;">
                        <td colspan="2" class="ps-4 fw-bold text-center py-3">TOTAL PEMBAYARAN</td>
                        <td class="text-end pe-4 fw-bold text-success py-3">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="p-4 bg-white">
            <form method="post">
                <button type="submit" name="simpan" class="btn-save shadow-sm">PROSES & SIMPAN TRANSAKSI</button>
            </form>
            
            <?php
            if(isset($_POST['simpan']) && $total > 0){
                $tanggal = date('Y-m-d H:i:s');
                mysqli_query($conn, "INSERT INTO transaksi VALUES('', '$tanggal', '$total')");
                $id_transaksi = mysqli_insert_id($conn);

                foreach($_SESSION['keranjang'] as $item){
                    $id = $item['id_barang'];
                    $jumlah = $item['jumlah'];
                    
                    mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah) VALUES ('$id_transaksi', '$id', '$jumlah')");

                    $ambil = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id'");
                    $b = mysqli_fetch_array($ambil);
                    $sub = $b['harga'] * $jumlah;

                    mysqli_query($conn, "UPDATE barang SET stok = stok - $jumlah, terjual = terjual + $jumlah, total_pemasukan = total_pemasukan + $sub WHERE id_barang='$id'");
                }
                $_SESSION['keranjang'] = [];
                echo "<script>alert('Transaksi Berhasil!'); window.location='transaksi.php';</script>";
            }
            ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#pilih_barang_keren').select2({
            placeholder: "Pilih barang..."
        });
    });
</script>
</body>
</html>