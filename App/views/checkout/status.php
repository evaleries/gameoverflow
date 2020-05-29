<!DOCTYPE html>
<html lang="id">

<?php importView('sections.front.head', ['pageTitle' => 'Order ' . $status ? 'Berhasil' : 'Gagal']) ?>

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
    <?php importView('sections.front.breadcrumb', ['breadcrumbs' => ['Home' => '/', 'Order Status' => '#']]) ?>
    <!-- Breadcrumb Section End -->
    
    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title text-center pt-4">Order Status</div>
                        <div class="card-body">
                            <div class="alert <?= $status ? 'alert-success' : 'alert-danger' ?>">
                                <p><?= $message ?></p>
                            </div>
                        </div>
                    </div>
                </div>
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