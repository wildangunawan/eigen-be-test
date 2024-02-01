# Eigen BE Test Case

## Installation

Instalasi dilakukan seperti biasa pada proyek Laravel:

```bash
git clone ...
composer install
cp .env.example .env
nano .env
php artisan key:generate
php artisan migrate --seed
```

## Usage

Jalankan aplikasi Laravel seperti biasa:

```bash
php artisan serve
```

Anda dapat mengunjungi aplikasi di [http://localhost:8000](http://localhost:8000) serta dokumentasi Swaggernya di [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation).

## Tests

Untuk menjalankan test case, jalankan perintah berikut:

```bash
php artisan test
```

## License

Laravel dilisensikan dengan [MIT license](https://opensource.org/licenses/MIT). Keseluruhan kode di dalam proyek ini akan
mengikuti lisensi ini.
