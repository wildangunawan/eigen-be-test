# Eigen BE Test Case

### Use Case

- Members can borrow books with conditions
    - [X]  Members may not borrow more than 2 books
    - [X]  Borrowed books are not borrowed by other members
    - [X]  Member is currently not being penalized
- Member returns the book with conditions
    - [X]  The returned book is a book that the member has borrowed
    - [X]  If the book is returned after more than 7 days, the member will be subject to a penalty. Member with penalty cannot able to borrow the book for 3 days
- Check the book
    - [X]  Shows all existing books and quantities
    - [X]  Books that are being borrowed are not counted
- Member check
    - [X]  Shows all existing members
    - [X]  The number of books being borrowed by each member

### Requirements

- [X]  it should be use any framework (using Laravel)
- [X]  it should be use Swagger as API Documentation ([http://localhost:8000/api/documentation](http://localhost:8000/api/documentation))
- [X]  it should be use Database (SQL/NoSQL)
- [X]  it should be open sourced on your github repo

### Extras

- [ ]  Implement [DDD Pattern]([https://khalilstemmler.com/articles/categories/domain-driven-design/](https://khalilstemmler.com/articles/categories/domain-driven-design/))
- [X]  Implement Unit Testing
- [X]  Implement Feature Testing

### Algoritma

Tes algoritma dapat diakses pada folder [`algorithm`](algorithm).
1. [Reverse alphabet](algorithm/soal1.py)
2. [Mencari kata terpanjang](algorithm/soal2.py)
3. [Menghitung jumlah kata pada array](algorithm/soal3.py)
4. [Mencari pengurangan dari diagnoal matriks](algorithm/soal4.py)

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
