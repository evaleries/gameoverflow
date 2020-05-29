<section class="breadcrumb-section set-bg" data-setbg="<?= asset('img/breadcrumb.png') ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <?php if (isset($breadcrumbs)): ?>
                    <h2><?= $currentPage = array_keys($breadcrumbs)[count($breadcrumbs) - 1] ?></h2>
                    <div class="breadcrumb__option">
                        <?php array_pop($breadcrumbs); foreach ($breadcrumbs as $title => $url): ?>
                            <a href="<?= startsWith($url, 'http') ? $url : route($url) ?>"><?= $title ?></a>
                        <?php endforeach; ?>
                        <span><?= $currentPage ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>