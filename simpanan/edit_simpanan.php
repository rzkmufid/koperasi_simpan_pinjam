<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';
$idSimpanan = $_GET['id'];
$queryGetSimpanan = "SELECT * FROM simpanan WHERE id = '$idSimpanan'";
$resultGetSimpanan = mysqli_query($conn, $queryGetSimpanan);
$simpanan = mysqli_fetch_assoc($resultGetSimpanan);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aplikasi Koperasi</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #3DDD6A;
            color: #ffffff;
            width: 100%;
            box-sizing: border-box;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .title {
            display: flex;
            align-items: center;
            justify-content: center;
            /* Tambahkan properti ini untuk meletakkan elemen di tengah */
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            flex: 1;
        }

        .logout-btn {
            background-color: #11A93B;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #0e8c31;
        }

        .dashboard {
            display: flex;
            flex: 1;
            width: 100%;
        }

        .sidebar {
            width: 250px;
            background-color: #3DDD6A;
            padding: 20px;
            text-align: center;
            box-sizing: border-box;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }

        .menu-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            color: white;
        }

        .sidebar-menu-item a {
            color: white;
            padding: 5px;
            border-radius: 8px;
            width: 100%;
            text-align: left;
        }

        .sidebar-menu-item:hover {
            border-radius: 8px;
            background-color: #0e8c31;
        }

        .sidebar-menu-item.active {
            border-radius: 8px;
            background-color: #0e8c31;

        }

        .menu-icon {
            font-size: 20px;
            margin-right: 10px;
            background-color: white;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3DDD6A;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            text-decoration: none;
            padding: 8px 12px;
            margin-right: 5px;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-warning {
            background-color: #ffc107;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        form {
            max-width: 400px;
            /* margin: auto; */
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-outline-success {
            border: 2px solid #28a745;
            color: #28a745;


        }
    </style>
</head>

<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="title">
            <img class="logo" src="../assets/img/logo.png" alt="Logo">
            <p>APLIKASI KOPERASI<br>SIMPAN PINJAM<br>JAYA SEJAHTERA</p>
        </div>
        <a class="logout-btn" href="../logout.php">&#128682; Logout</a>
    </div>

    <!-- Dashboard -->
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="menu-title">MENU UTAMA</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#127968;</div>
                    <a href="../">Home</a>
                </li>
                <?php if ($_SESSION['level'] == 'superadmin') { ?>
                    <li class="sidebar-menu-item">
                        <div class="menu-icon">&#128100;</div>
                        <a href="../userpage/">Data Admin</a>
                    </li>
                <?php } ?>
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#128100;</div>
                    <a href="../anggota/">Data Anggota</a>
                </li>
                <li class="sidebar-menu-item active">
                    <div class="menu-icon">&#128176;</div>
                    <a href="../simpanan/">Data Simpanan</a>
                </li>
                <div class="menu-title">TRANSAKSI</div>
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#128184;</div>
                    <a href="../pinjaman/">Data Peminjaman</a>
                </li>
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#128182;</div>
                    <a href="../angsuran/">Data Angsuran</a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <h2>Ubah Simpanan</h2>
            <form action="crud_simpanan.php" method="post">
                <input type="hidden" name="aksi" value="edit_simpanan">
                <div class="form-group">
                    <label for="nama_anggota">Nama Anggota:</label>


                    <input type="text" class="form-control" name="id" id="id" value="<?= $simpanan['nama_anggota'] ?>" required readonly>


                </div>
                <div class="form-group">
                    <label for="kode_transaksi">Id :</label>
                    <input type="text" class="form-control" name="id" id="id" value="<?= $_GET['id'] ?>" required readonly>
                </div>
                <div class="form-group">
                    <label for="kode_transaksi">Id Anggota:</label>
                    <input type="text" class="form-control" name="id_anggota" id="id_anggota" value="<?= $simpanan['id_anggota'] ?>" required readonly>
                </div>
                <div class="form-group">
                    <label for="kode_transaksi">Kode Transaksi:</label>
                    <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi" value="<?= $simpanan['kode_transaksi'] ?>" required readonly>
                </div>
                <div class="form-group">
                    <label for="tanggal_simpan">Tanggal Simpan:</label>
                    <input type="date" class="form-control" id="tanggal_simpan" name="tanggal_simpan" required>
                </div>
                <div class="form-group">
                    <label for="pokok">Pokok:</label>
                    <input type="text" class="form-control" id="pokok" name="pokok" required value="<?= $simpanan['pokok'] ?>">
                </div>
                <div class="form-group">
                    <label for="wajib">Wajib:</label>
                    <input type="text" class="form-control" id="wajib" name="wajib" required value="<?= $simpanan['wajib'] ?>">
                </div>
                <div class="form-group">
                    <label for="sukarela">Sukarela:</label>
                    <input type="text" class="form-control" id="sukarela" name="sukarela" required value="<?= $simpanan['sukarela'] ?>">
                </div>
                <button type="submit" class="btn btn-primary">Simpan Simpanan</button>
            </form>
        </div>
        <script>
            // Fungsi untuk mengisi nilai otomatis pada input tanggal
            document.addEventListener('DOMContentLoaded', function() {
                var today = new Date();
                var formattedDate = today.toISOString().split('T')[0];
                document.getElementById('tanggal_simpan').value = formattedDate;
            });

            document.getElementById('nama_anggota').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var idAnggota = selectedOption.getAttribute('data-id');
                document.getElementById('id_anggota').value = idAnggota;
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>