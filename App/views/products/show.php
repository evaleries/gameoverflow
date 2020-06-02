<!DOCTYPE html>
<html lang="id">

<?php importView('sections.front.head', ['pageTitle' => $product->title, 'pageMeta' => ['description' => $product->short_description]]); ?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <?php importVIew('sections.front.humberger') ?>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php importView('sections.front.header'); ?>
    <!-- Header Section End -->

    <?php importView('sections.front.hero', ['heroClass' => 'hero-normal']); ?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="<?= $product->getAssetImage() ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2><?= $product->title ?></h2>
                        <div class="breadcrumb__option">
                            <a href="<?= base_url() ?>">Home</a>
                            <a href="<?= route('products') ?>">Produk</a>
                            <a href="<?= route('products', ['category' => $product->category_slug]) ?>"><?= $product->category_name ?></a>
                            <span><?= $product->title ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                 src="<?= $product->getAssetImage() ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <form action="<?= route('cart') ?>" method="POST">
                    <div class="product__details__text">
                        <h3><?= $product->title ?></h3>
                        <div class="product__details__price"><?= $product->formattedPrice() ?></div>
                        <p><?= $product->short_description ?></p>
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="number" name="quantity" min="1" max="<?= $stock ?>" value="1">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?= $product->id ?>">
                        <input type="hidden" name="slug" value="<?= $product->slug ?>">
                        <?php if ($stock > 1): ?>
                        <input type="submit" class="primary-btn" style="border-style: none" value="Tambahkan ke keranjang">
                        <?php endif; ?>
                        <ul>
                            <li><b>Stok</b> <span><?= $stock > 0 ? $stock : '<b>Out of Stock</b>' ?></span></li>
                            <li><b>Kategori</b> <span><?=  $product->category_name ?></span></li>
                            <li><b>Developer</b> <a href="<?= $product->developer_website ?>" target="_new"><span><?= $product->developer_name ?></span></a></li>
                            <li><b>Tanggal Rilis</b> <span><?= $product->getReleasedAt() ?></span></li>
                            <li><b>Bagikan</b>
                                <div class="share">
                                    <a href="http://twitter.com/share?text=Buy <?= $product->title ?>&url=<?= route('products/'. $product->slug) ?>&hashtags=gameoverflow" target="_new"><i class="fa fa-retweet"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    </form>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#description" role="tab"
                                   aria-selected="true">Deskripsi</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="description" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Informasi Produk</h6>
                                    <p><?= nl2br($product->description) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
<!--    <section class="related-product">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-lg-12">-->
<!--                    <div class="section-title related__product__title">-->
<!--                        <h2>Related Product</h2>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-lg-3 col-md-4 col-sm-6">-->
<!--                    <div class="product__item">-->
<!--                        <div class="product__item__pic set-bg" data-setbg="img/product/product-1.jpg">-->
<!--                            <ul class="product__item__pic__hover">-->
<!--                                <li><a href="#"><i class="fa fa-heart"></i></a></li>-->
<!--                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>-->
<!--                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="product__item__text">-->
<!--                            <h6><a href="#">Crab Pool Security</a></h6>-->
<!--                            <h5>$30.00</h5>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-3 col-md-4 col-sm-6">-->
<!--                    <div class="product__item">-->
<!--                        <div class="product__item__pic set-bg" data-setbg="img/product/product-2.jpg">-->
<!--                            <ul class="product__item__pic__hover">-->
<!--                                <li><a href="#"><i class="fa fa-heart"></i></a></li>-->
<!--                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>-->
<!--                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="product__item__text">-->
<!--                            <h6><a href="#">Crab Pool Security</a></h6>-->
<!--                            <h5>$30.00</h5>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-3 col-md-4 col-sm-6">-->
<!--                    <div class="product__item">-->
<!--                        <div class="product__item__pic set-bg" data-setbg="img/product/product-3.jpg">-->
<!--                            <ul class="product__item__pic__hover">-->
<!--                                <li><a href="#"><i class="fa fa-heart"></i></a></li>-->
<!--                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>-->
<!--                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="product__item__text">-->
<!--                            <h6><a href="#">Crab Pool Security</a></h6>-->
<!--                            <h5>$30.00</h5>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-lg-3 col-md-4 col-sm-6">-->
<!--                    <div class="product__item">-->
<!--                        <div class="product__item__pic set-bg" data-setbg="img/product/product-7.jpg">-->
<!--                            <ul class="product__item__pic__hover">-->
<!--                                <li><a href="#"><i class="fa fa-heart"></i></a></li>-->
<!--                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>-->
<!--                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                        <div class="product__item__text">-->
<!--                            <h6><a href="#">Crab Pool Security</a></h6>-->
<!--                            <h5>$30.00</h5>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
    <!-- Related Product Section End -->

    <!-- Footer Section Begin -->
    <?php importView('sections.front.footer') ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php importView('sections.front.js') ?>


</body>

</html>