<!DOCTYPE html>
<html lang="id">

<?php importView('sections.front.head', ['pageTitle' => 'Shopping Cart']) ?>

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
    <?php importView('sections.front.breadcrumb', ['breadcrumbs' => ['Home' => '/', 'Keranjang' => '/cart']]) ?>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <?php if (!empty($carts['data'])) { ?>
                        <table>
                            <thead>
                            <tr>
                                <th class="shoping__product">Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($carts['data'] as $productId => $cart) { ?>
                            <tr>
                                <td class="shoping__cart__item">
                                    <img src="<?= $cart->image ?>" style="max-width: 30%;" alt="<?= $cart->title ?>">
                                    <h5><span><a href="<?= $cart->url ?>"><?= $cart->title ?></a></span></h5>
                                </td>
                                <td class="shoping__cart__price">
                                    <?= $cart->formattedPrice ?>
                                </td>
                                <td class="shoping__cart__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="number" class="item_quantity" data-id="<?= $productId ?>" value="<?= $cart->quantity ?>">
                                        </div>
                                    </div>
                                </td>
                                <td class="shoping__cart__total">
                                    <?= $cart->formattedTotalPrice ?>
                                </td>
                                <td class="shoping__cart__item__close">
                                    <span class="icon_close" data-id="<?= $productId ?>"></span>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="<?= route('products') ?>" class="primary-btn cart-btn">Lanjut Belanja</a>
                        <a href="javascript:none;" id="btnUpdate" class="primary-btn cart-btn cart-btn-right">Ubah Keranjang</a>
                    </div>
                </div>
                <div class="col-lg-6"></div>
                <div class="col-lg-6 d-float pull-right">
                    <div class="shoping__checkout">
                        <h5>Total Keranjang</h5>
                        <ul>
                            <li>Total <span><?= isset($carts['formattedTotalPrice']) ? $carts['formattedTotalPrice'] : '0' ?></span></li>
                        </ul>
                        <?php if (isset($carts['data']) && count($carts['data']) > 0) { ?>
                        <a href="<?= route('checkout') ?>" class="primary-btn <?= empty($carts['data']) ? 'disabled' : '' ?>">Lanjutkan Ke Pembayaran</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->

    <!-- Footer Section Begin -->
    <?php importView('sections.front.footer') ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php importView('sections.front.js') ?>

    <script>
        $(document).ready(function () {
            $('span.icon_close').on('click', function (e) {
               let data = {id: $(this).data('id')};
               let tr = $(this).parent().parent();
               $.post('<?= route('cart/delete') ?>', data, function (data, status) {
                   tr.remove();
                   window.location.reload();
               }).fail(function (err, status) {
                   console.error(err, status);
               })
            });

            $('#btnUpdate').on('click', function (e) {
                console.log('clicked');
                $(this).attr('disable', true);
                let data = {};
                $.each($('.item_quantity'), (i, v) => {
                    data[$(v).data('id')] = parseInt($(v).val());
                });
                $.post('<?= route('cart/update') ?>', {data: data}, function (data, status) {
                    window.location.reload();
                });
                e.preventDefault();
            });
        });
    </script>


</body>

</html>