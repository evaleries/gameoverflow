<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', ['css' => ['modules/izitoast/css/iziToast.min.css']]) ?>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
    
      <?php importView('sections.dashboard.nav-customer') ?>

      <?php importView('sections.dashboard.menu-customer') ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fab fa-steam"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>My Games</h4>
                  </div>
                  <div class="card-body">
                    <?= isset($totalGameOwned) ? $totalGameOwned : 0 ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Game in Store</h4>
                  </div>
                  <div class="card-body">
                    <?= isset($totalProductInStore) ? $totalProductInStore : 0 ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Orders</h4>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive table-invoice">
                    <table class="table table-striped">
                      <tr>
                        <th>Order ID</th>
                        <th>Invoice ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Action</th>
                      </tr>
                      <?php if(isset($orders)): foreach($orders as $order): ?>
                      <tr>
                        <td>#<?= $order->id ?></a></td>
                        <td><?= $order->no ?></a></td>
                        <td class="font-weight-600"><?= $order->title ?></td>
                        <td><div class="badge badge-<?= $order->payment_status == 1 ? 'primary' : 'warning' ?>"><?= $order->payment_status == 1 ? 'Confirmed' : 'Pending' ?></div></td>
                        <td><?= $order->due_date ?></td>
                        <td>
                          <a href="<?= route('customer/invoice', ['no' => $order->no]) ?>" class="btn btn-primary">Detail</a>
                        </td>
                      </tr>
                      <?php endforeach; endif; ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card card-success">
                <div class="card-header">
                  <h4>My Games</h4>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive table-invoice">
                    <table class="table table-striped">
                      <tr>
                        <th>Order ID</th>
                        <th>Game</th>
                        <th>Activation Code</th>
                        <th>Purchase Date</th>
                        <th>Action</th>
                      </tr>
                      <?php if(isset($myGames)): foreach($myGames as $game): ?>
                      <tr>
                        <td>#<?= $game->order_id ?></a></td>
                        <td class="font-weight-600"><?= $game->title ?></td>
                        <td class="activation-code"><?= ($game->status == 1) ? $game->activation_code : str_repeat('****', 4) ?></a></td>
                        <td><?= dt($game->bought_date, 'Y-m-d H:i:s', 'j F Y') ?></td>
                        <td>
                          <?php if ($game->status == 0): ?>
                            <a href="javascript:none" data-id="<?= $game->id ?>" class="btn btn-primary btn-redeem">Redeem</a>
                          <?php else: ?>
                            <a href="#" class="btn btn-success" disabled>Redeemed</a>
                          <?php endif; ?>
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

  <?php importView('sections.dashboard.js', ['js' => ['modules/izitoast/js/iziToast.min.js']]) ?>

  <script>
  $(document).ready(function () {
    $('.btn-redeem').on('click', function (e) {
      e.preventDefault();
      let tdActivationCode = $(this).parent().siblings('.activation-code');
      let btnRedeem = $(this);
      $.post('<?= route('customer/redeem') ?>', {pc_id: $(this).data('id')}, function (data, xhr) {
        iziToast.success({
          title: 'Redeem Success',
          message: 'Enjoy the game!',
          position: 'topRight'
        });

        if (data.activation_code != undefined) {
          tdActivationCode.text(data.activation_code);
        }
        btnRedeem.prop('disabled', true);

      }).fail(function (error) {
        iziToast.error({
          title: 'Error!',
          message: error,
          position: 'topRight'
        });
      });
    });
  });
  </script>

</body>
</html>