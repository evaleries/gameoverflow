<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= route('customer') ?>">Gameoverflow</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= route('customer') ?>">Go</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown <?=request()->is('/customer') ? 'active' : '' ?>">
                <a href="<?= route('customer') ?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="<?= base_url() ?>" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Home Page
            </a>
        </div>
    </aside>
</div>