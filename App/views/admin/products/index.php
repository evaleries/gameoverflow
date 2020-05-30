<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', ['pageTitle' => 'Create Product']) ?>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
    
      <?php importView('sections.dashboard.nav-admin') ?>

      <?php importView('sections.dashboard.menu-admin') ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Products</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?= route('admin') ?>">Dashboard</a></div>
              <div class="breadcrumb-item">Products</div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card card-info">
                <div class="card-header">
                  <h4>Products</h4>
                  <div class="card-header-action">
                    <a href="<?= route('admin/orders') ?>" class="btn btn-info"><i class="fas fa-search-plus"></i> Show All</a>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive table-invoice">
                    <table class="table table-striped">
                      <tr>
                        <th>Order ID</th>
                        <th>Invoice ID</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Order Date</th>
                        <th>Action</th>
                      </tr>
                      <?php if(isset($recentOrders)): foreach($recentOrders as $order): ?>
                      <tr>
                        <td>#<?= $order->id ?></a></td>
                        <td><?= $order->no ?></a></td>
                        <td><?= $order->name ?></td>
                        <td><div class="badge badge-<?= $order->determineStatusClass() ?>"><?= $order->getStatusString() ?></div></td>
                        <td><?= dt($order->due_date, 'Y-m-d H:i:s', 'j F Y') ?></td>
                        <td><?= $order->created_at ?></td>
                        <td>
                          <a href="<?= route('admin/invoice', ['no' => $order->no]) ?>" class="btn btn-primary">Detail</a>
                        </td>
                      </tr>
                      <?php endforeach; endif; ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

    
      <?php importView('sections.dashboard.footer') ?>
    </div>
  </div>

  <?php importView('sections.dashboard.js') ?>

</body>
</html>