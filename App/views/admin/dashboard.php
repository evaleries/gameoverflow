<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', ['css' => ['modules/jqvmap/dist/jqvmap.min.css']]) ?>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
    
      <?php importView('sections.dashboard.nav-admin') ?>

      <?php importView('sections.dashboard.menu-admin') ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Orders</h4>
                  </div>
                  <div class="card-body">
                    <?= isset($totalOrders) ? $totalOrders : 0 ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                  <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Processing Orders</h4>
                  </div>
                  <div class="card-body">
                    <?= isset($orderProcessing) ? $orderProcessing : 0 ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Payments Pending Confirmation</h4>
                  </div>
                  <div class="card-body">
                    <?= isset($paymentsPending) ? $paymentsPending : 0 ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Incomes vs Sales (2020)</h4>
                </div>
                <div class="card-body">
                  <canvas id="incomeChart" height="100"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Best 5 Products by Sales</h4>
                </div>
                <div class="card-body">
                  <div class="owl-carousel owl-theme" id="products-carousel">
                  <?php if (isset($bestProducts)): foreach($bestProducts as $product): ?>
                    <div>
                      <div class="product-item pb-3">
                        <div class="product-image">
                          <img alt="image" src="<?= $product->getAssetImage() ?>" class="img-fluid">
                        </div>
                        <div class="product-details">
                          <div class="product-name"><?= $product->title ?></div>
                          <div class="text-muted text-small"><?= $product->sales ?> sales</div>
                          <div class="product-cta">
                            <a href="<?= route('products/'. $product->slug) ?>" class="btn btn-primary">Detail</a>
                          </div>
                        </div>  
                      </div>
                    </div>
                  <?php endforeach; endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="row">
          </div> -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card card-info">
                <div class="card-header">
                  <h4>Recent Orders</h4>
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

  <?php importView('sections.dashboard.js', ['js' => ['modules/chart.min.js']]) ?>

  <script>
  var ctx = document.getElementById("incomeChart").getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: [<?= implode(', ', array_map(function($data) { return "'". $data->month ."'"; }, $incomes)) ?>],
      datasets: [{
        label: 'Sales',
        data: [<?= implode(', ', array_map(function($data) { return "'". $data->sales ."'"; }, $sales)) ?>],
        borderWidth: 2,
        backgroundColor: 'rgba(63,82,227,.8)',
        borderWidth: 0,
        borderColor: 'transparent',
        pointBorderWidth: 0,
        pointRadius: 3.5,
        pointBackgroundColor: 'transparent',
        pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
      },
      {
        label: 'Incomes',
        data: [<?= implode(', ', array_map(function($data) { return $data->income; }, $incomes)) ?>],
        borderWidth: 2,
        backgroundColor: 'rgba(254,86,83,.7)',
        borderWidth: 0,
        borderColor: 'transparent',
        pointBorderWidth: 0 ,
        pointRadius: 3.5,
        pointBackgroundColor: 'transparent',
        pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
      }]
    },
    options: {
      legend: {
        display: true
      },
      scales: {
        yAxes: [{
          gridLines: {
            // display: false,
            drawBorder: false,
            color: '#f2f2f2',
          },
          ticks: {
            beginAtZero: false,
            // stepSize: 1500,
            callback: function(value, index, values) {
              return value;
            }
          }
        }],
        xAxes: [{
          gridLines: {
            display: false,
            tickMarkLength: 15,
          }
        }]
      },
    }
  });

  $("#products-carousel").owlCarousel({
    items: 1,
    margin: 5,
    autoplay: true,
    autoplayTimeout: 5000,
    loop: true,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 1
      },
      1200: {
        items: 2
      }
    }
  });

  </script>

</body>
</html>