<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="<?= asset('img/logo.png') ?>" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, <?= auth()->name ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" onclick="document.getElementById('logoutForm').submit();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
                <form class="d-none" id="logoutForm" method="POST" action="<?= route('auth/logout') ?>">
                    <input type="hidden" name="logout_token" value="<?= session()->get('__logout_token') ?>">
                </form>
            </div>
        </li>
    </ul>
</nav>