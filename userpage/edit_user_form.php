<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../");
}

include '../db_connect.php'; // Sesuaikan dengan nama file dan lokasi koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Ambil data pengguna berdasarkan ID
    $result = $conn->query("SELECT * FROM users WHERE id = $user_id");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        // Redirect ke halaman daftar pengguna jika ID tidak ditemukan
        header("Location: user_list.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses form edit pengguna
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $level = $_POST['level'];
    $password = $_POST['password'];

    if (!empty($password)) {
        // Jika password baru diisi, gunakan password baru
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET username = '$username', level = '$level', password_hashed = '$password' WHERE id = '$user_id'";
    } else {
        // Jika password baru tidak diisi, gunakan password yang sudah ada
        $query = "UPDATE users SET username = '$username', level = '$level' WHERE id = '$user_id'";
    }

    // $query = "UPDATE users SET username = '$username', level = '$level' WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result) {
        header("Location: index.php");
    } else {
        $error_message = "Gagal mengedit pengguna.";
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
                    <li class="sidebar-menu-item active">
                        <div class="menu-icon">&#128100;</div>
                        <a href="index.php">Data Admin</a>
                    </li>
                <?php } ?>
                <li class="sidebar-menu-item ">
                    <div class="menu-icon">&#128100;</div>
                    <a href="../anggota">Data Anggota</a>
                </li>
                <li class="sidebar-menu-item ">
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

        <!-- Main Content -->
        <div class="main-content">
            <a href="index.php" class="btn btn-outline-success">Kembali</a>
            <h2>Edit Pengguna</h2>

            <?php
            if (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>

            <form method="post" action="">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <div class="form-group">
                    <label for="username">Nama Pengguna:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password Baru:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="jangan di isi jika tidak perlu">
                </div>
                <div class="form-group">
                    <select class="form-control" id="level" name="level" required>
                        <option value="admin" <?php echo ($user['level'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="superadmin" <?php echo ($user['level'] == 'superadmin') ? 'selected' : ''; ?>>Super Admin</option>
                        <!-- Tambahkan opsi sesuai dengan level yang dibutuhkan -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>

        <!-- Bootstrap JavaScript dan Popper.js -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>