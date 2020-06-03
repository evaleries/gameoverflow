<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', [
  'pageTitle' => 'Rekap Pesanan',
  'css' => [
    'modules/datatables/datatables.min.css',
    'modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
    'modules/bootstrap-daterangepicker/daterangepicker.css'
  ]
  ]);
?>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
    
      <?php importView('sections.dashboard.nav-admin') ?>

      <?php importView('sections.dashboard.menu-admin') ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Rekap Pesanan</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?= route('admin') ?>">Dashboard</a></div>
              <div class="breadcrumb-item">Rekap Pesanan</div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card card-info">
                <div class="card-header">
                  <h4>Rekap Pesanan</h4>
                  <div class="card-header-action">
                    <input type="hidden" name="filter" value="<?= __e(request()->filter ? request()->filter : 'daily') ?>">
                    <input type="hidden" name="start_date" value="<?= now() ?>">
                    <input type="hidden" name="end_date" value="<?= lastMonth() ?>">
                    <a href="javascript:;" class="btn btn-primary btn-datefilter icon-left btn-icon"><i class="fas fa-calendar"></i> Tanggal <span></span></a>
                    <a href="<?= route('admin/orders/recap', ['filter' => 'daily']) ?>" class="btn <?= request()->filter == 'daily' || request()->filter == null ? 'active' : '' ?>">Harian</a>
                    <a href="<?= route('admin/orders/recap', ['filter' => 'monthly']) ?>" class="btn <?= request()->filter == 'monthly' ? 'active' : '' ?>">Bulanan</a>
                    <a href="<?= route('admin/orders/recap', ['filter' => 'yearly']) ?>" class="btn <?= request()->filter == 'yearly' ? 'active' : '' ?>">Tahunan</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-recap">
                      <thead>
                        <tr>
                          <th>Tanggal</th>
                          <th>Total Pesanan</th>
                          <th>Produk Terjual</th>
                          <th>Pendapatan</th>
                        </tr>
                      </thead>
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

  <?php importView('sections.dashboard.js', [
    'js' => [
      'modules/datatables/datatables.min.js',
      'modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
      'modules/bootstrap-daterangepicker/daterangepicker.js'
    ]
  ]) ?>

  <script>
  $(document).ready(function () {
    const tableRecap = $('#table-recap').DataTable({
      dom: 'Bfrtip',
      processing: true,
      ajax: {
        url: '<?= route('admin/orders/recap/data') ?>',
        type: 'POST',
        data: function () {
          return {
            filter: $('input[name=filter]').val(),
            start_date: $('input[name=start_date]').val(),
            end_date: $('input[name=end_date]').val()
          }
        }
      },
      ordering: false,
      columns: [
        { data: "date" },
        { data: "total_order" },
        { data: "products_sold" },
        {
          data: "income",
          render: function(income) {
            return `Rp ${income},-`;
          }
        }
      ]
    });

    $('.btn-datefilter').daterangepicker({
      ranges: {
        'Hari ini'    : [moment(), moment()],
        'Minggu lalu' : [moment().subtract(6, 'days'), moment()],
        '30 hari lalu': [moment().subtract(29, 'days'), moment()],
        'Bulan ini'   : [moment().startOf('month'), moment().endOf('month')],
        'Bulan lalu'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment()
    }, function (start, end) {
      $('.btn-datefilter span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name=start_date]').val(start.format('YYYY-MM-DD'));
      $('input[name=end_date]').val(end.format('YYYY-MM-DD'));
      tableRecap.ajax.reload();
    });
  });
  </script>

</body>
</html>