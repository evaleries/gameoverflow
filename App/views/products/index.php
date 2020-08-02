<!DOCTYPE html>
<html lang="id">

<?php importView('sections.front.head'); ?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <?php importView('sections.front.humberger'); ?>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php importView('sections.front.header'); ?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <?php importView('sections.front.hero', ['heroClass' => 'hero-normal']); ?>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <?php importView('sections.front.breadcrumb', ['breadcrumbs' => ['Home' => '/', 'Produk' => '/products']]) ?>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Category</h4>
                            <ul>
                                <li><a href="<?= route('products') ?>">All</a></li>
                                <?php foreach ($categories as $category) { ?>
                                    <li class="<?= isset(request()->category) && request()->category == $category->slug ? 'active' : '' ?>"><a href="<?= route('products', ['category' => $category->slug], true) ?>"><?= $category->name ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="filter__item">
                        <div class="row">
                            <?php if (isset($products->data)) { ?>
                            <div class="col-lg-12">
                                <div class="filter__found">
                                    <h6><span><?= count($products->data) ?></span> Produk Ditemukan</h6>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <?php if (!empty($products->data)) {
    foreach ($products->data as $product) { ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="<?= $product->getAssetImage() ?>">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="http://twitter.com/share?text=Buy <?= $product->title ?>&url=<?= route('products/'.$product->slug) ?>&hashtags=gameoverflow"><i class="fa fa-retweet"></i></a></li>
                                        <li><a href="<?= route('products/'.$product->slug) ?>"><i class="fa fa-search"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="<?= route('products/'.$product->slug) ?>"><?= $product->title ?></a></h6>
                                    <h5><?= $product->getFormattedPrice(); ?></h5>
                                </div>
                            </div>
                        </div>
                        <?php }
} ?>
                    </div>
                    <?php if (isset($products->pages)) { ?>
                    <div class="product__pagination">
                        <?php if ($products->hasPrev) { ?>
                            <a href="<?= route('products', ['page' => $products->prevPage], true) ?>"><i class="fa fa-long-arrow-left"></i></a>
                        <?php } ?>

                        <?php for ($i = 1; $i < $products->pages; $i++) { ?>
                            <a href="<?= route('products', ['page' => $i]) ?>"><?= $i ?></a>
                        <?php } ?>

                        <?php if ($products->hasNext) { ?>
                            <a href="<?= route('products', ['page' => $products->nextPage], true) ?>"><i class="fa fa-long-arrow-right"></i></a>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Footer Section Begin -->
    <?php importView('sections.front.footer'); ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php importView('sections.front.js'); ?>


</body>

</html>