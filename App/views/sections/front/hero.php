<section class="hero <?= isset($heroClass) ? $heroClass : '' ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <ul>
                        <li><a href="<?= route('products') ?>">All</a></li>
                        <?php foreach ($categories as $category): ?>
                            <li><a href="<?= route('products', ['category' => $category->slug]) ?>"><?= $category->name ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="<?= route('products/search') ?>">
                            <input type="text" name="q" autocomplete="off" placeholder="Cari Produk ..." value="<?= request()->is('/products/search') && request()->q ? request()->q : '' ?>">
                            <button type="submit" class="site-btn">Cari</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 12312312</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
                <?php if (!isset($heroClass)): ?>
                <div class="hero__item set-bg" data-setbg="<?= asset('img/banner/banner-1.jpg') ?>" style="background-position-y: center;">
                    <div class="hero__text">
                        <span>GameOverflow</span>
                        <h2 class="text-white">Official <br />Game store</h2>
                        <a href="<?= route('products') ?>" class="primary-btn">Beli Sekarang</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>