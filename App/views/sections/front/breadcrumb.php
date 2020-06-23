<?php
$img = asset('img/breadcrumb.png');
if (request()->category)
    foreach($categories as $category)
        if (request()->category == $category->slug) $img = asset($category->image);
?>
<section class="breadcrumb-section set-bg" data-setbg="<?= $img ?>">
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