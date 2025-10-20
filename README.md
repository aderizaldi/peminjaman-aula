# SIPAULA

Aplikasi Penjadwalan dan Peminjaman Aula

## Spesifikasi

-   PHP 8.3
-   MySQL 8.0
-   NPM 10.8
-   Composer 2.7

## Instalasi

Clone aplikasi menggunakan git

```bash
git clone https://github.com/aderizaldi/peminjaman-aula.git
```

Buat file .env dan ubah

```bash
cp .env.example .env
```

Install Depedency

```bash
composer install
```

Link Storage

```bash
php artisan storage:link
```

Migrasi Database

```bash
php artisan migrate --seed
```

Build aplikasi menggunakan NPM

```bash
npm run build
```

Jalankan aplikasi local

```bash
php artisan serve
```
