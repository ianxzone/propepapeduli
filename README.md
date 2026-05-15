# ProPePa PEDULI LMS

Platform inovatif untuk mendukung implementasi Kurikulum Merdeka dan Proyek Penguatan Profil Pelajar Pancasila (P5).

## 🚀 Fitur Utama
- **Siklus PEDULI**: Alur pembelajaran terstruktur (Peka, Eksplorasi, Diskusi, Ungkapkan, Lakukan, Introspeksi).
- **Setup Wizard**: Konfigurasi sistem cepat untuk admin baru.
- **Gamifikasi**: Sistem poin dan lencana (badges) untuk memotivasi siswa.
- **Audit Trail & Keamanan**: Pencatatan aktivitas admin dan proteksi sistem berlapis.
- **Backup Management**: Sistem pencadangan database mandiri dari dashboard.
- **Dashboard Guru**: Monitoring progres siswa, feedback jurnal, dan laporan nilai.

## 🛠 Teknologi
- **Core**: Laravel 11 / 13
- **Styling**: Tailwind CSS & Material Design 3 Aesthetics
- **Frontend**: Blade Templating & Vanilla JS/Vite
- **Database**: MySQL

---

## 🌐 Panduan Deployment

### 1. Deployment di cPanel (Shared Hosting)
1. **Upload Files**: Kompres seluruh file project (kecuali `node_modules` dan `vendor`) ke dalam format `.zip` dan upload ke cPanel.
2. **Move Public**: Pindahkan isi folder `public` ke `public_html` atau gunakan `.htaccess` di root untuk mengarahkan traffic.
3. **Database**: Buat database baru di MySQL Databases, buat user, dan hubungkan keduanya.
4. **Environment**: Update file `.env` dengan kredensial database hosting.
5. **Install Dependencies**: Jalankan `composer install --no-dev` (jika ada akses SSH) atau upload folder `vendor` yang sudah terinstall di lokal.
6. **Symlink Storage**: Jalankan perintah `php artisan storage:link` via terminal atau cron job sekali jalan.
7. **Optimize**: Jalankan `php artisan config:cache` dan `php artisan route:cache`.

### 2. Deployment di Webuzo
1. **Domain Setup**: Tambahkan domain baru di panel Webuzo.
2. **App Directory**: Upload file project ke `/home/username/public_html/domain`.
3. **PHP Version**: Pastikan PHP version diatur ke 8.2 atau 8.3 via Webuzo PHP Selector.
4. **Database**: Buat database via Database Manager di Webuzo.
5. **Permissions**: Pastikan folder `storage` dan `bootstrap/cache` memiliki izin tulis (775 atau 755).
6. **Vite Build**: Jalankan `npm run build` di lokal dan upload folder `public/build`.

### 3. Deployment di VPS Polos (Ubuntu/Debian)
1. **Install Stack**:
   ```bash
   sudo apt update
   sudo apt install nginx mysql-server php8.3-fpm php8.3-mysql php8.3-xml php8.3-curl php8.3-mbstring php8.3-zip
   ```
2. **Clone Project**:
   ```bash
   cd /var/www
   git clone [URL_REPO] propepa
   cd propepa
   ```
3. **Configuration**:
   ```bash
   composer install --no-dev
   cp .env.example .env
   nano .env # Sesuaikan DB & APP_URL
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   sudo chown -R www-data:www-data storage bootstrap/cache
   ```
4. **Nginx Config**: Buat file konfigurasi di `/etc/nginx/sites-available/propepa` yang mengarah ke `/var/www/propepa/public`.
5. **Enable Site**:
   ```bash
   sudo ln -s /etc/nginx/sites-available/propepa /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl restart nginx
   ```

---

## 📝 Catatan Penting
- Gunakan `php artisan db:seed` untuk mengisi data dummy awal (Sekolah, Guru, Siswa).
- Pastikan `APP_DEBUG=false` di lingkungan produksi.
- Selalu lakukan backup database secara berkala melalui menu **Backup Data** di dashboard Admin.

Built with ❤️ by MATEK.
