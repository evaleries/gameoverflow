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
                    <h4>Game Saya</h4>
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
                    <h4>Total Game di Toko</h4>
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
                  <h4>Pesanan</h4>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive table-invoice">
                    <table class="table table-striped">
                      <tr>
                        <th>ID Pesanan</th>
                        <th>Tagihan ID</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Batas Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                      <?php if(isset($orders)): foreach($orders as $order): ?>
                      <tr>
                        <td>#<?= $order->id ?></a></td>
                        <td><?= $order->no ?></a></td>
                        <td class="font-weight-600"><?= $order->title ?></td>
                        <td><div class="badge badge-<?= \App\Models\Order::statusClass($order->status) ?>"><?= \App\Models\Order::statusString($order->status) ?></div></td>
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
                  <h4>Game Saya</h4>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <th>ID Game</th>
                        <th>Game</th>
                        <th>Kode Aktivasi</th>
                        <th>Aksi</th>
                      </tr>
                      <?php if(isset($myGames)): foreach($myGames as $game): ?>
                      <tr>
                        <td>#<?= $game->product_id ?></a></td>
                        <td class="font-weight-600"><?= $game->title ?></td>
                        <td class="activation-code"><?= ($game->status == 1) ? $game->activation_code : str_repeat('****', 4) ?></a></td>
                        <td>
                          <?php if ($game->status == 0): ?>
                            <a href="javascript:none" data-id="<?= $game->id ?>" class="btn btn-primary btn-redeem">Redeem</a>
                          <?php else: ?>
                            <a href="#" class="btn disabled btn-outline-success">Selesai</a>
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
        btnRedeem.removeClass().addClass('btn disabled btn-outline-success').text('Redeemed');

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