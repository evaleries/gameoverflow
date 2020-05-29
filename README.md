<p align="center">
<img src="https://raw.githubusercontent.com/evaleries/gameoverflow/master/public/assets/img/logo.png" alt="GameOverflow">
</p>

# GameOverflow
Project Pemrograman Berbasis Website - Tanpa Library/Composer.

## Ketentuan Project
- __Dilarang memakai library/composer__.
- __UI UX: 25 pts__
- __Fitur Keamanan: 25 pts__
- __Manage Invoices & Order__

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

## Implementasi
List yang sudah diimplementasi:
- Pipeline request ke 1 file php
- Routing (Url rewrite)
- Session (Session handling)
- Request (Incoming request handler)
- Database (Menggunakan PDO)
- Helpers
- Simle Closure Middleware (Fungsi pada routing yang akan dieksekusi sebelum meng-_invoke_ controller/closure)
- View Templating (Memanfaatkan fungsi _include_, _extract_, serta RegEx)

## TODO
Milestone yang perlu dicapai
- [x] Front page
- [X] Listing Products
- [X] Cart Session
- [X] Authentication
- [ ] User - Dashboard
- [ ] User - View Orders
- [ ] Admin - Dashboard
- [ ] Admin - Manage Invoice
- [ ] Admin - Manage Products
- [ ] Admin - Manage Orders
- [ ] Admin - Manage Users

## Flow
Alur / Life-cycle dari Request -> Response
1. Pipeline semua request ke public/index.php
2. Register Services ke ServiceContainer. (Yang sudah di register: Request & Session)
3. __ROUTING__: Regex url dengan routing yang sudah terdapat di routes.php
4. __ROUTING__: Cari Parameter dengan tipe Class untuk di inject dengan Service yang tersedia di ServiceContainer.
5. __ROUTING__: Invoke method pada controller / Closure dengan reflection class (jika controller, agar parent::__construct() dieksekusi) dan dengan call_user_func (jika closure)
6. __Controller__: Mengeksekusi isi method.
7. __Exception__: Menghandle apabila terjadi exception ketika proses eksekusi pada controller
