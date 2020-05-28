<!DOCTYPE html>
<html lang="id">

<?php importView('sections.head'); ?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <?php importView('sections.humberger'); ?>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php importView('sections.header'); ?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <?php importView('sections.hero', ['heroClass' => 'hero-normal']); ?>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="<?= asset('img/breadcrumb.png') ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>GameOverflow</h2>
                        <div class="breadcrumb__option">
                            <a href="<?= base_url() ?>">Home</a>
                            <a href="<?= base_url() ?>">Products</a>
                            <span>Search</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                                <?php foreach ($categories as $category): ?>
                                    <li class="<?= isset(request()->category) && request()->category == $category->slug ? 'active' : '' ?>"><a href="<?= route('products', ['category' => $category->slug], true) ?>"><?= $category->name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="filter__item">
                        <div class="row">
                            <!-- <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                            </div> -->
                            <?php if(isset($products->data)): ?>
                            <div class="col-lg-12">
                                <div class="filter__found">
                                    <h6><span><?= count($products->data) ?></span> Products found</h6>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="row">
                        <?php if(!empty($products->data)): foreach($products->data as $product): ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="<?= $product->getAssetImage() ?>">
                                    <ul class="product__item__pic__hover">
                                        <!-- <li><a href="#"><i class="fa fa-heart"></i></a></li> -->
                                        <li><a href="http://twitter.com/share?text=Buy <?= $product->title ?>&url=<?= route('products/'. $product->slug) ?>&hashtags=gameoverflow"><i class="fa fa-retweet"></i></a></li>
                                        <li><a href="<?= route('products/' . $product->slug) ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="<?= route('products/' . $product->slug) ?>"><?= $product->title ?></a></h6>
                                    <h5><?= $product->getFormattedPrice(); ?></h5>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                    <?php if (isset($products->pages)): ?>
                    <div class="product__pagination">
                        <?php if ($products->hasPrev): ?>
                            <a href="<?= route('products', ['page' => $products->prevPage], true) ?>"><i class="fa fa-long-arrow-left"></i></a>
                        <?php endif; ?>

                        <?php for($i = 1; $i < $products->pages; $i++): ?>
                            <a href="<?= route('products', ['page' => $i]) ?>"><?= $i ?></a>
                        <?php endfor; ?>

                        <?php if ($products->hasNext): ?>
                            <a href="<?= route('products', ['page' => $products->nextPage], true) ?>"><i class="fa fa-long-arrow-right"></i></a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Footer Section Begin -->
    <?php importView('sections.footer'); ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php importView('sections.front-js'); ?>


</body>

</html>