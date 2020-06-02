<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="<?= base_url() ?>"><img src="<?= asset('img/logo.png') ?>" alt="GameOverflow"></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="<?= route('cart') ?>"><i class="fa fa-shopping-bag"></i> <span><?= session()->has('__cart', 'totalProducts') ? session()->get('__cart', [])['totalProducts'] : 0 ?></span></a></li>
        </ul>
        <div class="header__cart__price">item: <span><?= session()->has('__cart', 'formattedTotalPrice') ? session()->get('__cart')['formattedTotalPrice'] : 0 ?></span></div>
    </div>
    <div class="humberger__menu__widget">
        <!-- <div class="header__top__right__language">
            <img src="<?= asset('img/language.png') ?>" alt="">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">Spanis</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div> -->
        <div class="header__top__right__auth">
        <?php if (isAuthenticated()): ?>
            <a href="<?= route(auth()->isAdmin() ? 'admin' : 'customer') ?>"><i class="fa fa-user"></i> <?= auth()->name ?></a>
        <?php else: ?>
            <a href="<?= route('auth/login') ?>"><i class="fa fa-user"></i> Login</a>
        <?php endif; ?>
        </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="<?= request()->is('/') ? 'active' : '' ?>"><a href="<?= base_url() ?>">Home</a></li>
            <li class="<?= request()->is('/products*') ? 'active' : '' ?>"><a href="<?= route('products') ?>">Produk</a></li>
            <li class="<?= request()->is('/cart') ? 'active' : '' ?>"><a href="<?= route('cart') ?>">Keranjang</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> hello@gameoverflow.test</li>
            <li>Official game store</li>
            <?php if (isAuthenticated()): ?>
            <li><form action="<?= route('auth/logout') ?>" method="POST"><input type="hidden" name="logout_token" value="<?= session()->get('__logout_token') ?>"><button type="submit" style="border-style: none"><i class="fa fa-sign-out"></i> Keluar</button></form></li>
            <?php endif; ?>
        </ul>
    </div>
</div>