# Judul Proyek

Projek CMS Laravel MSIB gits.id

## Author

- Name: Dwi Krisna Tantra
- University: Petra Christian University
- Stack: Laravel, Laravel Breeze, Bootstrap



### Persayaratan

- PHP 8.2.0 or higher
- Composer
- Node.js and npm
- MySQL 




## installation
1. clone repository:
git clone https://github.com/kristantra/msib_tugas_cms.git




2. Masuk ke directory proyek:



3. pasang dependency

composer install
npm install



4. copy .env.example 
cp .env.example .env



5. generate key aplikasi
php artisan key:generate

6. perbarui berkas .env dengan  database anda dan pengaturan konfigurasi lainnya


7. jalankan migrasi database
php artisan migrate

8. jalankan server
php artisan serve

9. buka browser dan buka `http://localhost:8000` untuk mengakses aplikasi.






