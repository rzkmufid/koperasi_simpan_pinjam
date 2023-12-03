<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

if (isset($_GET['id'])) {
    $pinjamanId = $_GET['id'];

    $pinjamanQuery = "SELECT * FROM pinjaman WHERE id_pinjaman = '$pinjamanId'";
    $pinjamanResult = mysqli_query($conn, $pinjamanQuery);
    $pinjaman = mysqli_fetch_assoc($pinjamanResult);

    if (!$pinjaman) {
        echo "Data peminjaman tidak ditemukan.";
        exit;
    }
}

// Update Pinjaman
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggalPinjaman = $_POST['tanggal_pinjam'];
    $jumlahPinjaman = $_POST['jumlah_pinjam'];
    $lamaPinjam = $_POST['lama_pinjam'];
    $bunga = $_POST['bunga'];
    $angsuran = $_POST['angsuran'];

    $updateQuery = "UPDATE pinjaman SET
                    tanggal_pinjaman = '$tanggalPinjaman',
                    jumlah_pinjaman = '$jumlahPinjaman',
                    lama_pinjam = '$lamaPinjam',
                    bunga = '$bunga',
                    angsuran = '$angsuran'
                    WHERE id_pinjaman = '$pinjamanId'";

    if (mysqli_query($conn, $updateQuery)) {
        header("Location: detail_pinjaman.php?id={$pinjaman['id_anggota']}");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
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
                    <a href="index.php">Data Anggota</a>
                </li>
                <li class="sidebar-menu-item">
                    <div class="menu-icon">&#128176;</div>
                    <a href="../simpanan/">Data Simpanan</a>
                </li>
                <div class="menu-title">TRANSAKSI</div>
                <li class="sidebar-menu-item active">
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
            <h2>Edit Peminjaman <?= $pinjaman['nama_anggota'] ?></h2>

            <!-- Form Edit Peminjaman -->
            <form action="edit_pinjaman.php?id=<?php echo $pinjaman['id_pinjaman']; ?>" method="post">
                <div class="form-group">
                    <label for="tanggal_pinjam">Tanggal Peminjaman:</label>
                    <input type="date" class="form-control" name="tanggal_pinjam" id="tanggal_pinjam" value="<?php echo $pinjaman['tanggal_pinjaman']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="jumlah_pinjam">Jumlah Pinjaman:</label>
                    <input type="text" class="form-control" name="jumlah_pinjam" id="jumlah_pinjam" value="<?php echo $pinjaman['jumlah_pinjaman']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="lama_pinjam">Lama Pinjaman (bulan):</label>
                    <input type="text" class="form-control" name="lama_pinjam" id="lama_pinjam" value="<?php echo $pinjaman['lama_pinjam']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="bunga">Bunga (%):</label>
                    <input type="text" class="form-control" name="bunga" id="bunga" value="<?php echo $pinjaman['bunga']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="angsuran">Angsuran:</label>
                    <input type="text" class="form-control" name="angsuran" id="angsuran" value="<?php echo $pinjaman['angsuran']; ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>

            <!-- Add back button or any other navigation options as needed -->
            <a href="detail_pinjaman.php?id=<?php echo $pinjaman['id_anggota']; ?>" class="btn btn-secondary">Kembali</a>

        </div>

</body>

</html>