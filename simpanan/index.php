<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

function getAnggotaList()
{
    global $conn;
    $query = "SELECT * FROM anggota";
    $result = mysqli_query($conn, $query);
    $anggotaList = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $anggotaList;
}

function getSimpananList($idAnggota)
{
    global $conn;
    $query = "SELECT * FROM simpanan WHERE id_anggota = '$idAnggota'";
    $result = mysqli_query($conn, $query);
    $simpananList = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $simpananList;
}

function isAnggotaHaveSimpanan($idAnggota)
{
    global $conn;
    $query = "SELECT COUNT(*) as count FROM simpanan WHERE id_anggota = '$idAnggota'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    return $count > 0;
}

function searchAnggota($keyword)
{
    global $conn;
    $query = "SELECT * FROM anggota WHERE nama LIKE '%$keyword%'";
    $result = mysqli_query($conn, $query);
    $searchResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $searchResult;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $anggotaList = searchAnggota($keyword);
} else {
    $anggotaList = getAnggotaList();
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

        #anggotaList {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        #anggotaList li {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f5f5f5;
        }

        #anggotaList li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            width: 80%;
        }

        #anggotaList li .text-success {
            color: #28a745;
        }

        #anggotaList li .btn-primary {
            margin-left: 10px;
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
            <h2>Daftar Simpanan</h2>
            <a href="cetak.php" class="btn btn-success">Cetak</a><br><br>
            <!-- Form Pencarian -->
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="keyword">Cari Anggota:</label>
                    <input type="text" class="form-control" name="keyword" id="keyword">
                </div>
                <!-- <a href="tambah_simpanan.php" class="btn btn-primary">Tambah Simpanan</a> -->
            </form>

            <!-- Daftar Anggota -->
            <ul id="anggotaList">
                <?php foreach ($anggotaList as $anggota) : ?>
                    <li>
                        <a href="detail_simpanan.php?id=<?= $anggota['id_anggota']; ?>"><?php echo $anggota['nama']; ?></a>
                        <?php if (isAnggotaHaveSimpanan($anggota['id_anggota'])) : ?>
                            <span class="text-success">Sudah Melakukan Simpanan</span>
                        <?php else : ?>
                            <a href="tambah_simpanan.php?id=<?php echo $anggota['id_anggota']; ?>" class="btn btn-sm btn-primary">Tambah Simpanan</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

</body>
<script>
    document.getElementById('keyword').addEventListener('input', function() {
        const keyword = this.value.toLowerCase();
        const anggotaList = document.getElementById('anggotaList');
        const anggotaItems = anggotaList.getElementsByTagName('li');

        for (let i = 0; i < anggotaItems.length; i++) {
            const anggotaName = anggotaItems[i].getElementsByTagName('a')[0].textContent.toLowerCase();

            if (anggotaName.includes(keyword)) {
                anggotaItems[i].style.display = '';
            } else {
                anggotaItems[i].style.display = 'none';
            }
        }
    });
</script>

</html>