<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', ['css' => [
    'modules/datatables/datatables.min.css',
    'modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
    'modules/summernote/summernote-bs4.css',
    'modules/jquery-selectric/selectric.css',
    'modules/bootstrap-daterangepicker/daterangepicker.css',
]]) ?>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
    
      <?php importView('sections.dashboard.nav-admin') ?>

      <?php importView('sections.dashboard.menu-admin') ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <div class="section-header-back">
              <a href="<?= route('admin/products') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Ubah Produk</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?= route('admin') ?>">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="<?= route('admin/products') ?>">Produk</a></div>
              <div class="breadcrumb-item">Ubah Produk</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Edit Produk</h2>

            <div class="row">
              <div class="col-12">
                <?php importView('sections.dashboard.validation-alert'); ?>
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Informasi Produk</h4>
                    <div class="card-header-action">
                      <a data-collapse="#info-product" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                  </div>
                  <div class="card-body collapse show" id="info-product">
                    <form action="<?= route('admin/products/'.$product->slug.'/update') ?>" method="POST">
                      <input type="hidden" name="product_id" value="<?= $product->id ?>">
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
                        <div class="col-sm-12 col-md-7">
                          <input type="text" class="form-control" name="title" value="<?= old('title', $product->title) ?>" >
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode</label>
                        <div class="col-sm-12 col-md-7">
                          <input type="text" class="form-control" name="code" value="<?= old('code', $product->code) ?>" required>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga</label>
                        <div class="input-group col-sm-12 col-md-7">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              Rp
                            </div>
                          </div>
                          <input type="text" class="form-control currency" name="price" value="<?= old('price', $product->price) ?>" required>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Developer</label>
                        <div class="col-sm-12 col-md-7">
                          <select class="form-control selectric" name="developer">
                          <?php foreach ($developers as $developer) { ?>
                            <option value="<?= $developer->id ?>" <?= $product->developer_id == $developer->id ? 'selected' : '' ?> ><?= $developer->name ?></option>
                          <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                        <div class="col-sm-12 col-md-7">
                          <select class="form-control selectric" name="category">
                          <?php foreach ($categories as $category) { ?>
                            <option value="<?= $category->id ?>" <?= $product->category_id == $category->id ? 'selected' : '' ?>><?= $category->name ?></option>
                          <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskripsi Singkat</label>
                        <div class="col-sm-12 col-md-7">
                          <textarea class="summernote-simple" name="short_description"><?= old('short_description', $product->short_description) ?></textarea>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskripsi Panjang</label>
                        <div class="col-sm-12 col-md-7">
                          <textarea class="summernote-simple" name="description"><?= old('description', $product->description) ?></textarea>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar</label>
                        <div class="col-sm-12 col-md-7">
                          <input type="text" class="form-control" name="image" value="<?= old('image', $product->image) ?>" placeholder="Link image" required>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Rilis</label>
                        <div class="col-sm-12 col-md-7">
                          <input type="text" name="released_at" class="form-control datepicker" value="<?= old('released_at', dt($product->released_at, 'j F Y', 'Y-m-d')) ?>">
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                          <button class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card card-info">
                  <div class="card-header">
                    <h4>Stok Produk</h4>
                    <div class="card-header-action">
                      <button id="btn-add-stock" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Stok</button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-stocks">
                        <thead>
                          <tr>
                            <td>ID</td>
                            <td>Kode Aktivasi</td>
                            <td>Dibuat Pada</td>
                            <td>Dirubah Pada</td>
                            <td>Aksi</td>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <form class="modal-part" id="modal-edit-activation">
          <input type="hidden" name="id">
          <div class="form-group">
            <label>Kode Aktivasi</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-key"></i>
                </div>
              </div>
              <input type="text" class="form-control" placeholder="kode aktivasi" name="activation_code">
            </div>
          </div>
        </form>
      </div>

    
      <?php importView('sections.dashboard.footer') ?>
    </div>
  </div>

  <?php importView('sections.dashboard.js', ['js' => [
      'modules/summernote/summernote-bs4.js',
      'modules/jquery-selectric/jquery.selectric.min.js',
      'modules/bootstrap-daterangepicker/daterangepicker.js',
      'modules/cleave-js/dist/cleave.min.js',
      'modules/datatables/datatables.min.js',
      'modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
      'https://cdn.jsdelivr.net/npm/sweetalert2@9',
  ]]) ?>

  <script>
  var editor;
  $(document).ready(function() {
    $("select").selectric();
    var cleaveC = new Cleave('.currency', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
    });

    const tableStock = $('#table-stocks').DataTable({
      ajax: '<?= route('admin/products/'.$product->id.'/stocks') ?>',
      ordering: false,
      columns: [
        { data: "id" },
        { data: "activation_code" },
        { data: "created_at" },
        { data: "updated_at" }
      ],
      columnDefs: [
        {
          targets: 4,
          visible: true,
          defaultContent: '<button class="btn btn-md btn-warning btn-edit-stock"><i class="fa fa-edit"></i> Edit</button> <button class="btn btn-md btn-danger btn-delete-stock"><i class="fas fa-trash"></i> Delete</button>'
        }
      ]
    });

    function deleteProductCode(element) {
      let data = tableStock.row( $(element).parents('tr') ).data();
      $.post(`<?= route('admin/products/stocks/') ?>${data.id}/delete`, {id: data.id}, function () {
        Swal.fire('Sukses', 'Kode produk berhasil dihapus!', 'success');
        tableStock.ajax.reload();
      }).fail(function (err) {
        Swal.fire('Gagal!', 'Kode produk gagal dihapus!');
      });
    }

    $('#btn-add-stock').on('click', function (e) {
      Swal.fire({
        title: 'Tambah Stock',
        input: 'textarea',
        showCancelButton: true,
        allowOutsideCick: () => !Swal.isLoading(),
        confirmButtonText: '<i class="fa fa-plus"></i> Tambah',
        preConfirm: (val) => {
          return $.post(`<?= route('admin/products/'.$product->id.'/stocks/create') ?>`, {data: val}, function () {
            return true;
          }).fail(function (err) {
            Swal.fire('Gagal!', 'Gagal menambahkan data', 'error');
          })
        }
      }).then((result) => {
        if (result.value) {
          tableStock.ajax.reload();
          Swal.fire('Sukses', 'Data berhasil ditambahkan!', 'success');
        }
      });
    });

    $('#table-stocks tbody').on('click', '.btn-delete-stock', function (e) {
      e.preventDefault();
      let data = tableStock.row( $(this).parents('tr') ).data();
      Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah anda yakin menghapus kode produk ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus',
        preConfirm: () => {
          return $.post(`<?= route('admin/products/stocks/delete') ?>`, {id: data.id}, function() {
            return true;
          }).fail(function (err) {
            Swal.fire('Gagal!', 'Gagal menghapus kode aktivasi produk', 'error');
            return false;
          })
        }
      }).then((result) => {
        if (result.value) {
          tableStock.ajax.reload();
          Swal.fire(
            'Sukses!',
            'Kode aktivasi produk berhasil dihapus',
            'success'
          )
        }
      })
    })

    $('#table-stocks tbody').on('click', '.btn-edit-stock', function (e) {
      e.preventDefault();
      let data = tableStock.row( $(this).parents('tr') ).data();

      Swal.fire({
        title: 'Edit Produk',
        input: 'text',
        inputValue: data.activation_code,
        showCancelButton: true,
        inputPlaceholder: 'Kode aktivasi',
        allowOutsideClick: () => !Swal.isLoading(),
        confirmButtonText: '<i class="fa fa-save"></i> Simpan',
        preConfirm: (activation_code) => {
          if (activation_code == data.activation_code) return;

          return $.post(`<?= route('admin/products/stocks/') ?>${data.id}/update`, {activation_code}, function () {
            return true;
          }).fail(function (err) {
            Swal.showValidationMessage(
              `Request failed: ${error}`
            );
          })
        }
      }).then((result) => {
        if (result.value) {
          Swal.fire('Sukses', 'Sukses merubah kode!', 'success');
          tableStock.ajax.reload();
        }
      });
    });
  });
  </script>

</body>
</html>