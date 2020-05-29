<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; GameOverflow</title>

    <!--  icon  -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= asset('site.webmanifest') ?>">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= asset('dashboard/modules/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('dashboard/modules/fontawesome/css/all.min.css') ?>">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= asset('dashboard/modules/bootstrap-social/bootstrap-social.css') ?>">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= asset('dashboard/css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('dashboard/css/components.css') ?>">

</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="<?= asset('img/logo.png') ?>" alt="logo" width="50%" class="shadow-light rounded-circle">
                        </div>

                        <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->flash('error') ?>
                        </div>
                        <?php endif; ?>
                        <?php if (session()->has('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->flash('success') ?>
                            </div>
                        <?php endif; ?>

                        <div class="card card-primary">
                            <div class="card-header"><h4>Login</h4></div>

                            <div class="card-body">
                                <form method="POST" action="<?= route('auth/authenticate') ?>" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus value="<?= old('email') ?>">
                                        <div class="invalid-feedback">
                                            <?= session()->flash('validation_error', 'email', 'Masukkan email yang valid!') ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                            <div class="invalid-feedback">
                                                <?= session()->flash('validation_error', 'password', 'Masukkan password yang valid!') ?>
                                            </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Belum punya akun? <a href="<?= route('auth/register') ?>">Buat baru</a>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; GameOverflow <?= date('Y') ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="<?= asset('dashboard/modules/jquery.min.js') ?>"></script>
    <script src="<?= asset('dashboard/modules/popper.js') ?>"></script>
    <script src="<?= asset('dashboard/modules/tooltip.js') ?>"></script>
    <script src="<?= asset('dashboard/modules/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= asset('dashboard/modules/nicescroll/jquery.nicescroll.min.js') ?>"></script>
    <script src="<?= asset('dashboard/modules/moment.min.js') ?>"></script>
    <script src="<?= asset('dashboard/js/stisla.js') ?>"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="<?= asset('dashboard/js/scripts.js') ?>"></script>
    <script src="<?= asset('dashboard/js/custom.js') ?>"></script>

</body>
</html>