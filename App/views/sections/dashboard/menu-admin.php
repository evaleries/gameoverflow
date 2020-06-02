<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= route('admin') ?>">Gameoverflow</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= route('admin') ?>">Go</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown <?= request()->is('/admin') ? 'active' : '' ?>">
                <a href="<?= route('admin') ?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-header">Menu Produk</li>
            <li class="dropdown <?= request()->is('/admin/products*') ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-boxes"></i> <span>Produk</span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?= route('admin/products') ?>" class="nav-link">Daftar Produk</a></li>
                    <li><a href="<?= route('admin/products/create') ?>" class="nav-link">Buat Produk</a></li>
                </ul>
            </li>

            <li class="menu-header">Menu Pesanan</li>
            <li class="dropdown <?= request()->is('/admin/orders*') ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i> <span>Pesanan</span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?= route('admin/orders') ?>" class="nav-link">Daftar Pesanan</a></li>
                </ul>
            </li>

        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="<?= base_url() ?>" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Halaman Utama
            </a>
        </div>
    </aside>
</div>