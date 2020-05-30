<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> hello@gameoverflow.test</li>
                            <li>Official game store!</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__language">
                            <?php if (isAuthenticated()): ?>
                            <form action="<?= route('auth/logout') ?>" method="POST"><input type="hidden" name="logout_token" value="<?= session()->get('__logout_token') ?>"><button type="submit" style="border-style: none"><i class="fa fa-sign-out"></i> Logout</button></form>
                            <?php endif; ?>
                        </div>
                        <div class="header__top__right__auth">
                            <?php if (isAuthenticated()): ?>
                                <a href="<?= route(auth()->isAdmin() ? 'admin' : 'customer') ?>"><i class="fa fa-user"></i> <?= auth()->name ?></a>
                            <?php else: ?>
                                <a href="<?= route('auth/login') ?>"><i class="fa fa-user"></i> Login</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="<?= base_url() ?>"><img src="<?= asset('img/logo.png') ?>" class="header-img d-none d-sm-none d-md-inline-block" alt="GameOverflow"></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="<?= request()->is('/') ? 'active' : '' ?>"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="<?= request()->is('/products*') ? 'active' : '' ?>"><a href="<?= route('products') ?>">Products</a></li>
                        <li class="<?= request()->is('/cart') ? 'active' : '' ?>"><a href="<?= route('cart') ?>">Carts</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="<?= route('cart') ?>"><i class="fa fa-shopping-bag"></i> <span><?= session()->has('__cart', 'totalProducts') ? session()->get('__cart', [])['totalProducts'] : 0 ?></span></a></li>
                    </ul>
                    <div class="header__cart__price">item: <span><?= session()->has('__cart', 'formattedTotalPrice') ? session()->get('__cart')['formattedTotalPrice'] : 0 ?></span></div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
