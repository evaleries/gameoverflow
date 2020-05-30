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

            <li class="menu-header">Manage Products</li>
            <li class="dropdown <?= request()->is('/admin/products*') ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-boxes"></i> <span>Products</span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?= route('admin/products') ?>" class="nav-link">Products</a></li>
                    <li><a href="<?= route('admin/products/create') ?>" class="nav-link">Create Product</a></li>
                </ul>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="<?= base_url() ?>" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Home Page
            </a>
        </div>
    </aside>
</div>