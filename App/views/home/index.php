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
    <?php importView('sections.front.hero'); ?>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <?php importView('sections.front.categories-slider'); ?>
    <!-- Categories Section End -->

    <!-- Latest Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Produk Unggulan</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            <?php foreach ($categories as $category) { ?>
                                <li data-filter=".cat-<?= $category->id ?>"><?= $category->name ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <?php if (!empty($products)) {
    foreach ($products as $product) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix cat-<?= $product->category_id ?>">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="<?= $product->getAssetImage() ?>">
                            <ul class="featured__item__pic__hover">
                                <li><a href="http://twitter.com/share?text=Buy <?= $product->title ?>&url=<?= route('products/'.$product->slug) ?>&hashtags=gameoverflow"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="<?= route('products/'.$product->slug) ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="<?= route('products/'.$product->slug) ?>"><?= $product->title ?></a></h6>
                            <h5><?= $product->getFormattedPrice(); ?></h5>
                        </div>
                    </div>
                </div>
                <?php }
} ?>
            </div>
        </div>
    </section>
    <!-- Latest Section End -->


    <!-- Footer Section Begin -->
    <?php importView('sections.front.footer'); ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php importView('sections.front.js'); ?>


</body>

</html>