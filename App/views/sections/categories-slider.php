<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <?php foreach ($categories as $category): ?>
                <div class="col-lg-3">
                    <div class="categories__item set-bg" data-setbg="<?= $category->getAssetImage() ?>">
                        <h5><a href="<?= route('products', ['category' => $category->slug]) ?>"><?= $category->name ?></a></h5>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>