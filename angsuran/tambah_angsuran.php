<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}
include '../db_connect.php';

$pinjamanQuery = "SELECT * FROM pinjaman WHERE lunas = 0";
$pinjamanResult = mysqli_query($conn, $pinjamanQuery);
$pinjamanList = mysqli_fetch_all($pinjamanResult, MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses tambah angsuran
    $idPinjaman = $_POST['id_pinjaman'];
    $tanggalAngsuran = $_POST['tanggal_angsuran'];
    $jumlahAngsuran = $_POST['jumlah_angsuran'];
    // ...

    header("Location: index_angsuran.php");
    exit;
}

function generateNomorBukti()
{
    $prefix = 'AG'; // Anda dapat menentukan prefix sesuai kebutuhan
    $timestamp = time(); // Timestamp sebagai bagian dari nomor bukti
    $randomNumber = mt_rand(1000, 9999); // Angka acak sebagai bagian dari nomor bukti

    $nomorBukti = $prefix . '_' . $timestamp . '_' . $randomNumber;
    return $nomorBukti;
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
                <li class="sidebar-menu-item ">
                    <div class="menu-icon">&#128184;</div>
                    <a href="../pinjaman/">Data Peminjaman</a>
                </li>
                <li class="sidebar-menu-item active">
                    <div class="menu-icon">&#128182;</div>
                    <a href="../angsuran/">Data Angsuran</a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <h2>Tambah Angsuran</h2>

            <!-- Form Tambah Angsuran -->
            <form action="proses_angsuran.php" method="post">
                <!-- Pilihan Pinjaman -->
                <div class="form-group">
                    <label for="nama_anggota">Nama Anggota:</label>
                    <select class="form-control" name="nama_anggota" id="nama_anggota" required>
                        <option value="">-- select --</option>
                        <?php
                        include '../db_connect.php';

                        $query_anggota = "SELECT * FROM anggota";
                        $result_anggota = mysqli_query($conn, $query_anggota);

                        while ($row_anggota = mysqli_fetch_assoc($result_anggota)) {
                        ?>
                            <option value='<?= $row_anggota['nama'] ?>' data-id='<?= $row_anggota['id_anggota'] ?>'><?= $row_anggota['nama'] ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_anggota">Id Anggota:</label>
                    <input type="text" class="form-control" name="id_anggota" id="id_anggota" required readonly>
                </div>

                <div class="form-group">
                    <label for="id_pinjaman">ID Pinjaman:</label>
                    <select class="form-control" name="id_pinjaman" id="id_pinjaman" required>
                        <option value="">-- Pilih Pinjaman --</option>
                        <?php foreach ($pinjamanList as $pinjaman) : ?>
                            <option value="<?= $pinjaman['id_pinjaman']; ?>">
                                <?= $pinjaman['id_pinjaman']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Tanggal Angsuran dan Jumlah Angsuran -->
                <div class="form-group">
                    <label for="tanggal_pinjaman">Tanggal Pinjaman:</label>
                    <input type="date" class="form-control" name="tanggal_pinjaman" id="tanggal_pinjaman" required readonly>
                </div>
                <div class="form-group">
                    <label for="lama_pinjaman">Lama Pinjaman:</label>
                    <input type="text" class="form-control" name="lama_pinjaman" id="lama_pinjaman" required readonly>
                </div>
                <div class="form-group">
                    <label for="total_pinjaman">Total Pinjaman:</label>
                    <input type="text" class="form-control" name="total_pinjaman" id="total_pinjaman" required readonly>
                </div>
                <div class="form-group">
                    <label for="angsuran">Angsuran (bulan):</label>
                    <input type="text" class="form-control" name="angsuran" id="angsuran" required readonly>
                </div>
                <div class="form-group">
                    <label for="no_bukti">Nomor Bukti:</label>
                    <input type="text" class="form-control" name="no_bukti" id="no_bukti" value="<?= generateNomorBukti() ?>" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_angsuran">Tanggal Angsuran:</label>
                    <input type="date" class="form-control" name="tanggal_angsuran" id="tanggal_angsuran" required>
                </div>
                <div class="form-group">
                    <label for="total_bayar">Bayar Angsuran: (bulan)</label>
                    <input type="text" class="form-control" name="total_bayar" id="total_bayar" required>
                </div>
                <div class="form-group">
                    <label for="angsuran_ke">Angsuran Ke:</label>
                    <input type="text" class="form-control" name="angsuran_ke" id="angsuran_ke" required>
                </div>
                <div class="form-group">
                    <label for="sisa">Sisa</label>
                    <input type="text" class="form-control" name="sisa" id="sisa" required readonly>
                </div>

                <!-- Add other required fields here -->

                <button type="submit" class="btn btn-primary">Tambah Angsuran</button>
            </form>

        </div>

        <script>
            document.getElementById('nama_anggota').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var idAnggota = selectedOption.getAttribute('data-id');
                document.getElementById('id_anggota').value = idAnggota;
                console.log('ID Anggota:', idAnggota);

                // Fetch available loans for the selected anggota
                fetch('get_pinjaman.php?id=' + idAnggota)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Data Pinjaman:', data);

                        // Isi dropdown dengan opsi
                        var selectPinjaman = document.getElementById('id_pinjaman');
                        selectPinjaman.innerHTML = '<option value="">-- Pilih Pinjaman --</option>';
                        data.forEach(pinjaman => {
                            // Tambahkan kondisi untuk menampilkan hanya pinjaman yang belum lunas
                            if (pinjaman.lunas == 0) {
                                id_pinjam = pinjaman.id_pinjaman;
                                tgl_pinjam = pinjaman.tanggal_pinjaman;
                                lama_pinjam = pinjaman.lama_pinjam;
                                angsuran = pinjaman.angsuran;
                                bunga = pinjaman.bunga;
                                jumlahPinjaman = pinjaman.jumlah_pinjaman;
                                var option = document.createElement('option');
                                option.value = id_pinjam;
                                option.setAttribute('data-tanggal', tgl_pinjam);
                                option.setAttribute('data-lama', lama_pinjam);
                                option.setAttribute('data-angsuran', angsuran);
                                option.setAttribute('data-bunga', bunga);
                                option.setAttribute('data-pinjaman', jumlahPinjaman);
                                option.textContent = id_pinjam;
                                selectPinjaman.appendChild(option);
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            });

            document.getElementById('id_pinjaman').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var tanggalPinjaman = selectedOption.getAttribute('data-tanggal');
                var lamaPinjaman = selectedOption.getAttribute('data-lama');
                var jumlahAngsuran = selectedOption.getAttribute('data-angsuran');

                var totalKeseluruhan = jumlahAngsuran * lamaPinjaman;
                document.getElementById('total_pinjaman').value = totalKeseluruhan.toFixed(2);

                document.getElementById('tanggal_pinjaman').value = tanggalPinjaman;
                document.getElementById('lama_pinjaman').value = lamaPinjaman;
                document.getElementById('angsuran').value = jumlahAngsuran;

                console.log('Tanggal Pinjaman:', tanggalPinjaman);
                console.log('Lama Pinjaman:', lamaPinjaman);
                console.log('Jumlah Angsuran:', jumlahAngsuran);
            });

            document.getElementById('total_bayar').addEventListener('input', hitungSisa);

            function hitungSisa() {
                var totalPinjaman = parseFloat(document.getElementById('total_pinjaman').value) || 0;
                var totalBayar = parseFloat(document.getElementById('total_bayar').value) || 0;

                var sisa = totalPinjaman - totalBayar;
                document.getElementById('sisa').value = sisa.toFixed(2);
            }
        </script>

</body>

</html>