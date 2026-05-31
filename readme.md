A. nama project: minipos-js
deskripsi:
Mini-POS adalah aplikasi penjualan berbasis web (PHP & JavaScript) untuk mengelola transaksi, stok barang, dan laporan secara cepat serta akurat. Fitur utama meliputi login, dashboard, transaksi penjualan, cetak struk, laporan harian, bulanan, dan barang terlaris. Sistem membantu meningkatkan efisiensi operasional dan mendukung keputusan manajemen

B. fitur:
Aplikasi minipos-js menggunakan code: PHP dan JavaScript, database MySQL dengan
menggunakan Local Development Environment yaitu Laragon. Untuk mendukung unjuk kerja Aplikasi Minipos-js digunakan JavaScript digunakan sebagai bahasa pemrograman sisi klien, AJAX digunakan untuk komunikasi asynchronous antara client dan server, sedangkan JSON digunakan sebagai format pertukaran data.

1. Login
   untuk menjalan aplikasi ini, diperlukan user baru. silahkan run program: buat_user.php. Secara default nama user: Meta dan password: metamedia
2. Dashboard. Menampilkan informasi: Total Barang Terjual, Total Transaksi dan Total Penjualan
3. Transaksi Penjualan Barang menggunakan JavaScript
   <br>
   3.1 CRUD
   3.2 Transasksi Penjualan secara real time
   3.3 Searching data penjualan
   3.4 Pagination
   3.5 Mencetak/print dan menampilkan Struk per nomor struk
4. Laporan
   4.1 Laporan Harian Penjualan, berdasarkan tanggal, Print
   4.2 Laporan Bulanan Penjualan,
   a. Print
   b. Print PDF
   c. Export Laporan ke Excel
   4.3 Laporan Barang Terlaris (fast moving)
5. Logout

bisa menampilkan faktur pembelian berdasarkan nomor faktur dari combo Faktur 4.

C. teknologi:

1.  HTML
2.  Tailwind
3.  PHP
4.  JavaScript
    AJAX
    JSON
5.  MySQL
6.  Server Laragon: apache

D. cara install

1. Install Laragon

2. Masuk ke folder wwww dan buat folder baru: minipos-js
3. Download SourceCode dari gitHub
   4.Dari DBMS --> PHPMyAdmin
4. pilih tab SQL
5. buat Database: db_penjualan dengan cara: copy-paste script SQL db_penjualan.sql
6. go / Kirim

7. dari Browser
8. pastikan server Apache dan MySQL sudah aktif
9. run
10. localhost/minipos-js

E. screenshot
![/image](/image/TampilanDepan.jpg)
![/image](/image/FakturPembelian-2.jpg)
![/image](/image/fakturPDF.jpg)
