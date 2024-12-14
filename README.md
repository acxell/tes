# Sistem Manajemen Janji Temu Pasien

## Prasyarat

Sebelum menjalankan aplikasi ini, pastikan Anda sudah menginstall dan mengkonfigurasi hal-hal berikut:

- PHP 8.x atau lebih tinggi
- Composer
- Laravel 10.x
- MySQL atau MariaDB
- Redis (untuk Queue, opsional tapi disarankan)

## Langkah Instalasi

Ikuti langkah-langkah berikut untuk menginstal aplikasi ini:

1. **Install needs**  
   composer install
2. **.env**  
   cp .env.example .env

   Pastikan .env nya memiliki 
   QUEUE_CONNECTION=database

3. **Artisan Key**  
   php artisan key:generate

4. **DB**  
   php artisan migrate

5. **Membuat queue / antrian berjalan di local**  
   php artisan queue:work

6. **Test**  
   php artisan test

7. **Serve**  
   php artisan serve

8. **Link to Swagger API Documentation**
   go to https://localhost:8000/api/documentation

