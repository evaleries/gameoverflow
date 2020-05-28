<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="<?= base_url() ?>"><img src="<?= asset('img/logo.png') ?>" alt="GameOverflow"></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="<?= route('cart') ?>"><i class="fa fa-shopping-bag"></i> <span><?= App\Core\Session::has('__cart', 'totalProducts') ? App\Core\Session::get('__cart', [])['totalProducts'] : 0 ?></span></a></li>
        </ul>
        <div class="header__cart__price">item: <span><?= App\Core\Session::has('__cart', 'formattedTotalPrice') ? App\Core\Session::get('__cart')['formattedTotalPrice'] : 0 ?></span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <img src="<?= asset('img/language.png') ?>" alt="">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">Spanis</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>
        <div class="header__top__right__auth">
            <a href="#"><i class="fa fa-user"></i> Login</a>
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="<?= base_url() ?>">Home</a></li>
            <li><a href="<?= route('products') ?>">Products</a></li>
            <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="./shop-details.html">Shop Details</a></li>
                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                    <li><a href="./checkout.html">Check Out</a></li>
                    <li><a href="./blog-details.html">Blog Details</a></li>
                </ul>
            </li>
            <li><a href="./blog.html">Blog</a></li>
            <li><a href="./contact.html">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> hello@gameoverflow.test</li>
            <li>Free Shipping for all Order of $99</li>
        </ul>
    </div>
</div>