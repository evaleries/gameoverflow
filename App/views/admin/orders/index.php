<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', [
    'pageTitle' => 'Pesanan',
    'css'       => [
        'modules/datatables/datatables.min.css',
        'modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
    ],
])
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
            <h1>Pesanan</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?= route('admin') ?>">Dashboard</a></div>
              <div class="breadcrumb-item">Pesanan</div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
            <?php session()->has('success') ? importView('sections.dashboard.alert', ['status' => 'success', 'message' => session()->flash('success')]) : '' ?>
              <div class="card card-info">
                <div class="card-header">
                  <h4>Pesanan</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-orders">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>No Invoice</th>
                          <th>Status Pesanan</th>
                          <th>Status Pembayaran</th>
                          <th>Tanggal Pesanan</th>
                          <th>Jatuh Tempo</th>
                          <th>Aksi</th>
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
      ],
  ]) ?>

  <script>
  $(document).ready(function () {
    const tableOrders = $('#table-orders').DataTable({
      dom: 'Bfrtip',
      ajax: '<?= route('admin/orders/api') ?>',
      ordering: false,
      columns: [
        { data: "id" },
        { data: "invoice_no" },
        { 
          data: "order_status",
          render: function (order_status) {
            switch (order_status) {
              case '0':
                return '<span class="badge badge-warning"> Tertunda';
              break;

              case '1':
                return '<span class="badge badge-info"> Dalam proses';
              break;

              case '2':
                return '<span class="badge badge-success"> Selesai';
              break;

              default:
                return '<span class="badge badge-danger"> Dibatalkan';
              break;
            }
          }
        },
        { 
          data: "payment_status",
          render: function (payment_status) {
            if (payment_status == 0) {
              return '<span class="badge badge-warning"> Perlu Konfirimasi';
            }

            return '<span class="badge badge-success"> Terkonfirmasi';
          }
        },
        { data: "created_at" },
        { data: "due_date" }
      ],
      columnDefs: [
        {
          targets: 6,
          defaultContent: '<button class="btn btn-info"><i class="fa fa-search-plus"></i> Detail</button>'
        }
      ]
    });

    $('#table-orders tbody').on('click', '.btn-info', function (e) {
      e.preventDefault();
      let data = tableOrders.row( $(this).parents('tr') ).data();
      window.location.href = `<?= route('admin/orders/detail/') ?>${data.id}`;
    });
  });
  </script>

</body>
</html>