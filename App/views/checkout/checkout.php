<!DOCTYPE html>
<html lang="id">

<?php importView('sections.front.head', ['pageTitle' => 'Checkout']) ?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <?php importView('sections.front.humberger') ?>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <?php importView('sections.front.header') ?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <?php importView('sections.front.hero', ['heroClass' => 'hero-normal']) ?>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <?php importView('sections.front.breadcrumb', ['breadcrumbs' => ['Home' => '/', 'Pembayaran' => 'checkout']]) ?>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <h4>Detail Tagihan</h4>
                <form action="<?= route('checkout/process') ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <?php importView('sections.dashboard.validation-alert') ?>
                            <p><strong>Transfer ke nomor rekening berikut: BCA 2494829310 a/n GameOverflow</strong></p>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Nama <span>*</span></p>
                                        <input type="text" name="name" value="<?= old('name', auth()->name) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <p>Bank <span>*</span></p>
                                    <select name="bank_name" class="form-control">
                                        <option value="BCA">BCA</option>
                                        <option value="BNI">BNI</option>
                                        <option value="BRI">BRI</option>
                                        <option value="BTN">BTN</option>
                                        <option value="MANDIRI">MANDIRI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>No Rekening<span>*</span></p>
                                        <input type="text" name="bank_number" value="<?= old('bank_number') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Catatan Pesanan<span>*</span></p>
                                <input type="text" name="description" value="<?= old('description') ?>" placeholder="Catatan tentang pesanan anda, misalnya catatan untuk pengiriman">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="checkout__order">
                                <h4>Pesanan Anda</h4>
                                <div class="checkout__order__products">Produk <span>Total</span></div>
                                <ul>
                                    <?php foreach($carts['data'] as $productId => $cart): ?>
                                        <li><?= $cart->title ?> <span><?= $cart->formattedTotalPrice ?></span></li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="checkout__order__total mt-4">Total <span><?= $carts['formattedTotalPrice'] ?></span></div>
                                <button type="submit" class="site-btn">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Footer Section Begin -->
    <?php importView('sections.front.footer') ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php importView('sections.front.js') ?>


</body>

</html>