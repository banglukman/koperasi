<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi Babussalam Selayar</title>
    <style>
        /* ... (Style tetap sama seperti sebelumnya) ... */
        body { 
            font-family: 
            'Segoe UI', sans-serif;
             background-color: #1f5347; 
             padding: 20px; }
        .header-container {
             display: flex; 
             align-items: center; 
             margin-bottom: 30px;
             padding: 10px; background: #a8ebac; border-radius: 12px; }
        .logo { width: 80px; margin-right: 20px; }
        .title-text h2 { margin: 0; color: #1b5e20; }
        .btn { text-decoration: none; padding: 12px 20px; border-radius: 8px; font-weight: 600; display: inline-flex; transition: 0.3s; }
        .btn-tambah { background-color: #2ecc71; color: white; margin-right: 10px; }
        .btn-transaksi { background-color: #3498db; color: white; }
        .table-container { background: white; padding: 10px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #fdfdfd; color: #95a5a6; text-transform: uppercase; font-size: 11px; padding: 20px; text-align: left; border-bottom: 2px solid #f1f1f1; }
        td { padding: 20px; border-bottom: 1px solid #f9f9f9; font-size: 14px; }
        
        /* Warna khusus untuk kolom baru */
        .stok-badge { background: #f1f1f1; padding: 4px 12px; border-radius: 20px; font-weight: bold; }
        .terjual-badge { background: #e8f4fd; color: #2980b9; padding: 4px 12px; border-radius: 20px; font-weight: bold; }
        .pemasukan-text { color: #27ae60; font-weight: bold; }
        .aksi-link { text-decoration: none; font-weight: bold; }
        .edit { color: #3498db; margin-right: 10px; }
        .hapus { color: #e74c3c; }
    </style>
</head>
<body>

    <div class="header-container">
        <img src="logo.png" alt="Logo" class="logo">
        <div class="title-text">
            <h2>Koperasi Babussalam Selayar</h2>
            <p>Manajemen Data Barang & Inventaris</p>
        </div>
    </div>

    <div class="nav-container" style="margin-bottom: 20px;">
        <a href="tambah.php" class="btn btn-tambah">+ Tambah Barang</a>
        <a href="transaksi.php" class="btn btn-transaksi">Transaksi Baru</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Stok Sisa</th>
                    <th>Terjual</th>
                    <th>Total Pemasukan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $grand_total_pemasukan = 0; // Untuk hitung total semua penjualan
                $data = mysqli_query($conn, "SELECT * FROM barang");
                while($d = mysqli_fetch_array($data)){
                    // Jika kolom 'terjual' belum ada di DB, kita asumsikan 0 dulu
                    $terjual = isset($d['terjual']) ? $d['terjual'] : 0;
                    $pemasukan = $d['harga'] * $terjual;
                    $grand_total_pemasukan += $pemasukan;
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><strong><?php echo $d['nama_barang']; ?></strong></td>
                    <td>Rp <?php echo number_format($d['harga'], 0, ',', '.'); ?></td>
                    <td><span class="stok-badge"><?php echo $d['stok']; ?></span></td>
                    <td><span class="terjual-badge"><?php echo $terjual; ?></span></td>
                    <td class="pemasukan-text">Rp <?php echo number_format($pemasukan, 0, ',', '.'); ?></td>
                    <td align="center">
                        <a href="edit.php?id=<?php echo $d['id_barang']; ?>" class="aksi-link edit">Edit</a>
                        <a href="hapus.php?id=<?php echo $d['id_barang']; ?>" class="aksi-link hapus" onclick="return confirm('Hapus data?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr style="background: #f1f8e9; font-weight: bold;">
                    <td colspan="5" align="right">TOTAL PENDAPATAN KOPERASI:</td>
                    <td class="pemasukan-text" style="font-size: 18px;">Rp <?php echo number_format($grand_total_pemasukan, 0, ',', '.'); ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>