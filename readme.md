A. NAMA PROJECT: <a href="http://localhost/minipos-js/login.php" target="_blank">minipos-js </a><br>
Deskripsi: <br>
Mini-POS adalah aplikasi penjualan berbasis web (PHP & JavaScript) untuk mengelola stok barang, transaksi, dan laporan secara cepat serta akurat. Fitur utama meliputi login, dashboard, barang, transaksi penjualan (aplikasi memotong stock barang setiap kali ada penjualan), cetak struk, laporan harian, bulanan, dan barang terlaris. Laporan bisa di print dan di export ke Excel. Sistem membantu meningkatkan efisiensi operasional dan mendukung keputusan manajemen.

Selain itu, aplikasi Minipos-js ini juga menerapkan tata kelola transparansi dalam kegiatan penjualan barang, hal ini terlihat dari Struk dimana nama petugas ditampikan pada Struk seusai dengan user yang bertugas saat itu.

KLASIFIKASI STACK <br>

Front End <br>
├── HTML <br>
├── Tailwind CSS <br>
├── JavaScript <br>
├── AJAX <br>
├── Chart.js <br>
└── User Interface <br>
<br>
Back End <br>
├── PHP <br>
├── MySQL <br>
├── Session <br>
├── CRUD <br>
├── API <br>
├── Login <br>
├── Export Excel <br>
└── Business Logic <br>
<br>
B. PENGEMBANGAN FITUR: <br>
Aplikasi minipos-js menggunakan code: PHP dan JavaScript, database MySQL dengan
menggunakan Local Development Environment yaitu Laragon. Untuk mendukung unjuk kerja Aplikasi Minipos-js digunakan JavaScript digunakan sebagai bahasa pemrograman sisi klien, AJAX digunakan untuk komunikasi asynchronous antara client dan server, sedangkan JSON digunakan sebagai format pertukaran data.
<br>

1. Login. Masuk ke Sistem.
   Untuk menjalan aplikasi ini, diperlukan user baru. silahkan <b> run program: buat_user.php </b>. Secara default nama user: Meta dan password: metamedia
2. Barang. Pengelolaan data barang meliputi kegiatan: CRUD + Search
3. Dashboard. Menampilkan informasi: Total Barang Terjual, Total Transaksi dan Total Penjualan
4. Transaksi Penjualan Barang menggunakan JavaScript
   <br>
   4.1.CRUD <br>
   4.2.Transasksi Penjualan secara real time <br>
   4.3 Searching data penjualan <br>
   4.4 Pagination <br>
   4.5 Mencetak/print dan menampilkan Struk per nomor struk<br>
5. Laporan <br>
   5.1 Laporan Harian Penjualan, berdasarkan tanggal, Print <br>
   5.2 Laporan Bulanan Penjualan: <br>
   5.2.1. Print <br>
   5.2.2. Print PDF <br>
   5.2.3. Export Laporan ke Excel <br>
   5.3 Laporan Barang Terlaris (fast moving) <br>
6. Grafik Penjualan Barang Terlaris<br>
7. Logout. Keluar dari Sistem <br>

C. TEKNOLOGI: <br>

1.  HTML
2.  Tailwind
3.  PHP
4.  JavaScript:
    AJAX dan JSON
5.  CSS
6.  MySQL
7.  Server Laragon: apache

D. CARA INSTALL <br>

1. Install Laragon

2. Masuk ke folder wwww dan buat folder baru: minipos-js
3. Download SourceCode dari [gitHub](https://github.com/amrin2017/minipos-js)
4. Dari DBMS --> PHPMyAdmin
   1.pilih tab SQL, hapus semua script yang tampil
   2.buat Database: db_penjualan dengan cara: copy-paste script SQL db_penjualan.sql
   3.go / Kirim

5. dari Browser
   1.pastikan server Apache dan MySQL sudah aktif
6. run
7. localhost/minipos-js

secara sederhana:

git clone https://github.com/amrin2017/minipos-js.git

E. SCREENSHOT <br>
![/image](/image/login.png)
![/image](/image/dashboard.png)
![/image](/image/laporan_barang.png)
![/image](/image/transaksi_penjualan.png)
![/image](/image/struk.png)
![/image](/image/laporan_penjualan_harian.png)
![/image](/image/laporan_bulanan_penjualan.png)
![/image](/image/laporan_bulanan_print.png)
![/image](/image/laporan_barang_terlaris.png)
![/image](/image/grafik_barang_terlaris.png)
![/image](/image/laporan_bulanan_excel.png)
