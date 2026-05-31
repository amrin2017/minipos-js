<!-- 
 login.php

// Universitas Metamedia, Padang
// Fakultas Teknologi Informasi dan Industri Kreatif
// Program Studi : Sistem Informasi
// Matakuliah Pemrogaraman Web
// Dosen: Ir. Muhammad Amrin Lubis, M.Sc, email: mamrinlubis@metamedia.ac.id

// Pendaftaran mahasiswa baru: https://pmb.metamedia.ac.id/beranda_pmb
  -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex items-center justify-center h-screen">

        <div class="bg-white p-8 rounded shadow w-96">

            <h1 class="text-2xl font-bold mb-6 text-center">
                🔐 Login Mini POS
            </h1>

            <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-100 text-red-600 p-2 mb-4 rounded">
                Username atau Password salah
            </div>
            <?php endif; ?>

            <form action="proses_login.php" method="POST">

                <div class="mb-4">
                    <label>Username</label>
                    <input type="text" name="username" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label>Password</label>
                    <input type="password" name="password" class="w-full border p-2 rounded" required>
                </div>

                <button class="bg-blue-500 text-white w-full p-2 rounded">
                    Login
                </button>

            </form>

        </div>

    </div>

</body>

</html>
?>