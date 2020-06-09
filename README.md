<p align="center">
<img src="https://raw.githubusercontent.com/evaleries/gameoverflow/master/public/assets/img/logo.png" alt="GameOverflow">
</p>

# GameOverflow
MVC e-commerce, Project Pemrograman Berbasis Website - Tanpa Library/Composer.

## Live Demo
GameOverflow dapat dilihat melalui demo [go.reach.my.id](http://go.reach.my.id)

## Ketentuan Project
- __Dilarang memakai library/composer__.
- __Manajemen stok barang: 25 pts__
    - Prosedur Penambahan barang baru
    - Prosedur Update barang
    - Prosedur Hapus stok barang
- __Mekanisme penjualan barang secara online: 25 pts__
    - Prosedur keranjang belanja
    - Invoice & nota
    - Rekap harian / bulanan / tahunan
- __UI UX: 25 pts__
- __Design DB, Keamanan, Auth, etc: 25 pts__

## Yang perlu dipelajari
Adapun materi dan refrensi yang didapatkan untuk membangun project ini:
- [Reflection Class - ORM](https://catchmetech.com/en/post/94/how-to-create-an-orm-framework-in-pure-php-orm-creation-tutorial)
- [Simple Routing](https://steampixel.de/en/simple-and-elegant-url-routing-with-php/)
- [Create your own MVC Framework in PHP](https://medium.com/@noufel.gouirhate/create-your-own-mvc-framework-in-php-af7bd1f0ca19)
- [How To Start Your Own PHP MVC Framework In 4 Steps?](https://phpocean.com/tutorials/back-end/how-to-start-your-own-php-mvc-framework-in-4-steps/28)
- [Implementation of dependency injection in php](https://catchmetech.com/en/post/95/implementation-of-dependency-injection-in-php)
- [How to invoke method on class with dynamicall generated name via reflection](https://catchmetech.com/en/post/91/how-to-invoke-method-on-class-with-dynamicall-generated-name-via-reflection)
- [PHP Session](https://stackoverflow.com/questions/16398392/php-session-in-class)
- [(The only proper) PDO tutorial](https://phpdelusions.net/pdo)
- [Passing a variable from one php include file to another: global vs. not](https://stackoverflow.com/questions/4675932/passing-a-variable-from-one-php-include-file-to-another-global-vs-not)
- [PHP Magic Methods](https://www.tutorialdocs.com/article/16-php-magic-methods.html)

## Implementasi
List yang sudah diimplementasi:
- Pipeline request ke 1 file php
- Routing (Url rewrite)
- Service Container
- Dependency Injection 
- Session (Session handling)
- Request (Incoming request handler)
- Database (Menggunakan PDO)
- Helpers
- Simple Closure Middleware (Fungsi pada routing yang akan dieksekusi sebelum meng-_invoke_ controller/closure)
- View Templating (Memanfaatkan fungsi _include_, _extract_, serta RegEx)

## TODO
Milestone yang perlu dicapai
- [x] Front page
- [X] Listing Products
- [X] Cart Session
- [X] Authentication
- [X] User - Dashboard
- [X] User - View Invoices
- [X] User - Redeem Games
- [X] Admin - Dashboard
- [X] Admin - Manage Products
- [X] Admin - Manage Orders
- [X] Admin - Orders Recap
- [X] Admin - Manage Categories
- [X] Admin - Manage Developers

## Flow
Alur / Life-cycle dari Request -> Response
1. Pipeline semua request ke public/index.php
2. Register Services ke ServiceContainer. (Yang sudah di register: Request, Session, & DB)
3. __ROUTING__: Regex url dengan routing yang sudah terdapat di routes.php
4. __ROUTING__: Cari Parameter dengan tipe Class untuk di inject dengan Service yang tersedia di ServiceContainer.
5. __ROUTING__: Invoke method pada controller / Closure dengan reflection class (jika controller, agar parent::__construct() dieksekusi) dan dengan call_user_func (jika closure)
6. __Controller__: Mengeksekusi isi method.
7. __Exception__: Menghandle apabila terjadi exception ketika proses eksekusi pada controller

## Credits
Thanks to Colorlib & Stisla.
