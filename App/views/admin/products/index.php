<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', [
  'pageTitle' => 'Products',
  'css' => [
    'modules/datatables/datatables.min.css',
    'modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css'
  ]
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
            <h1>Products</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?= route('admin') ?>">Dashboard</a></div>
              <div class="breadcrumb-item">Products</div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
            <?php session()->has('success') ? importView('sections.dashboard.alert', ['status' => 'success', 'message' => session()->flash('success')]) : '' ?>
              <div class="card card-info">
                <div class="card-header">
                  <h4>Produk</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-products">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Judul</th>
                          <th>Harga</th>
                          <th>Kategori</th>
                          <th>Developer</th>
                          <th>Tanggal Rilis</th>
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
      'modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js'
    ]
  ]) ?>

  <script>
  $(document).ready(function () {
    $('#table-products').DataTable({
      dom: 'Bfrtip',
      ajax: '<?= route('admin/products/api') ?>',
      ordering: false,
      columns: [
        { data: "id" },
        { data: "title" },
        {
          data: "price",
          render: function (val, type, row) {
            return val == 0 ? 'Gratis' : 'Rp ' + val + ',-'
          }
        },
        { data: "category" },
        { data: "developer" },
        { data: "released_at" },
        { 
          data: "slug",
          render: function (val, type, row) {
            return `<a href="<?= route('admin/products/') ?>${val}/edit" class="btn btn-info"><i class="fas fa-pencil"></i> Edit</a>`
          }
        }
      ]
    });
  });
  </script>

</body>
</html>