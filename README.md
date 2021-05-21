<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Before Start

- Jalankan composer install
- Konfigurasikan .env untuk koneksi database
- Jalankan perintah `php artisan migrate`

## API

[POST] /api/v1/order *Create Order baru*
[GET] /api/v1/order/{order_number} *Get Detail Order*
[POST] /api/v1/order/progress *Update Progress Order*

[POST] /api/v1/payment *Upload bukti payment*
[POST] /api/v1/payment/update *Update status bukti payment*

## Test 2

- Jalankan `php artisan test:two`
- Masukkan jumlah matriks
- Masukkan input angka untuk matriks
- Selesai
