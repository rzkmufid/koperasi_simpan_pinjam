<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Koperasi Simpan Pinjam</title>
    <style>
        body {
            background-color: #3DDD6A;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            /* Sesuaikan ukuran logo */
            height: 100px;
            /* Sesuaikan ukuran logo */
            margin-bottom: 10px;
            /* Tambahkan properti lainnya sesuai kebutuhan */
        }

        .title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 18px;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        input {
            width: 250px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-top: 5px;
            /* Tambahkan properti lainnya sesuai kebutuhan */
        }

        .icon {
            /* position: absolute; */
            top: 50%;
            transform: translateY(-50%);
            /* left: 10px; */
            color: #333;
        }

        .login-btn,
        .logout-btn {
            background-color: #11A93B;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            /* Tambahkan properti lainnya sesuai kebutuhan */
        }

        .login-btn:hover,
        .logout-btn:hover {
            background-color: #0e8c31;
            /* Sesuaikan warna hover sesuai kebutuhan */
        }
    </style>
</head>

<body>

    <div class="container">
        <img class="logo" src="../assets/img/logo.png" alt="Logo">
        <div class="title">APLIKASI KOPERASI SIMPAN PINJAM</div>
        <div class="subtitle">JAYA SEJAHTERA</div>
    </div>


    <form action="proses_login.php" method="post">
        <div class="form-group">
            <label for="username">&#128100;</label>
            <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <label for="password">&#128274;</label>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="login-btn">Login</button>
    </form>

    <!-- Jika ingin menambahkan tombol keluar -->
    <!-- <button class="logout-btn" onclick="logout()">Keluar</button> -->

</body>

</html>