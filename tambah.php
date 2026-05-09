<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){

    mysqli_query($conn, "INSERT INTO barang 
    VALUES(
        '', 
        '$_POST[nama]', 
        '$_POST[harga]', 
        '$_POST[stok]',
        '0',
        '0'
    )");

    echo "
    <script>
        alert('Barang berhasil ditambahkan!');
        window.location='index.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #dfe9f3, #ffffff);
            min-height: 100vh;
        }

        .card-modern{
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.75);
            border: 1px solid rgba(255,255,255,0.4);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .input-modern{
            border-radius: 14px !important;
            padding: 14px !important;
            border: 1px solid #dbeafe !important;
            transition: 0.3s;
        }

        .input-modern:focus{
            border-color: #22c55e !important;
            box-shadow: 0 0 0 4px rgba(34,197,94,0.15) !important;
        }

        .btn-modern{
            border-radius: 14px;
            padding: 14px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-modern:hover{
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

<div class="container py-5">

    <!-- Header -->
    <div class="text-center mb-5">

        <h1 class="fw-bold text-success">
            Tambah Data Barang
        </h1>

        <p class="text-secondary">
            Tambahkan inventaris baru ke sistem koperasi
        </p>

    </div>

    <!-- Card -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card-modern rounded-5 p-5">

                <!-- Judul -->
                <div class="d-flex align-items-center mb-4">

                    <div class="bg-success text-white rounded-4 p-3 me-3 shadow">
                        ➕
                    </div>

                    <div>
                        <h4 class="fw-bold m-0">
                            Form Tambah Barang
                        </h4>

                        <small class="text-secondary">
                            Input data barang baru koperasi
                        </small>
                    </div>

                </div>

                <!-- Form -->
                <form method="post">

                    <!-- Nama -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Nama Barang
                        </label>

                        <input 
                            type="text"
                            name="nama"
                            class="form-control input-modern"
                            placeholder="Masukkan nama barang"
                            required
                        >

                    </div>

                    <!-- Harga -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Harga Barang
                        </label>

                        <input 
                            type="number"
                            name="harga"
                            class="form-control input-modern"
                            placeholder="Masukkan harga barang"
                            required
                        >

                    </div>

                    <!-- Stok -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Jumlah Stok
                        </label>

                        <input 
                            type="number"
                            name="stok"
                            class="form-control input-modern"
                            placeholder="Masukkan jumlah stok"
                            required
                        >

                    </div>

                    <!-- Button -->
                    <div class="d-grid gap-3 mt-5">

                        <button 
                            type="submit"
                            name="simpan"
                            class="btn btn-success btn-modern shadow"
                        >
                            💾 Simpan Data Barang
                        </button>

                        <a href="index.php" class="btn btn-light btn-modern border">
                            ← Kembali
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>