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
            <h2 class="section-title">Ubah Produk</h2>

            <div class="row">
              <div class="col-12">
                <?php importView('sections.dashboard.validation-alert'); ?>
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Informasi Produk</h4>
                  </div>
                  <div class="card-body">
                    <form action="<?= route('admin/products/'. $product->slug .'/update') ?>" method="POST">
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
                          <?php foreach($developers as $developer): ?>
                            <option value="<?= $developer->id ?>" <?= $product->developer_id == $developer->id ? 'selected' : '' ?> ><?= $developer->name ?></option>
                          <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                        <div class="col-sm-12 col-md-7">
                          <select class="form-control selectric" name="category">
                          <?php foreach($categories as $category): ?>
                            <option value="<?= $category->id ?>" <?= $product->category_id == $category->id ? 'selected' : '' ?>><?= $category->name ?></option>
                          <?php endforeach; ?>
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
      </div>

    
      <?php importView('sections.dashboard.footer') ?>
    </div>
  </div>

  <?php importView('sections.dashboard.js', ['js' => [
    'modules/summernote/summernote-bs4.js',
    'modules/jquery-selectric/jquery.selectric.min.js',
    'modules/upload-preview/assets/js/jquery.uploadPreview.min.js',
    'modules/bootstrap-daterangepicker/daterangepicker.js',
    'modules/cleave-js/dist/cleave.min.js',
    'modules/datatables/datatables.min.js',
    'modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
  ]]) ?>

  <script>
  var editor;
  $(document).ready(function() {
    $("select").selectric();
    $.uploadPreview({
      input_field: "#image-upload",   // Default: .image-upload
      preview_box: "#image-preview",  // Default: .image-preview
      label_field: "#image-label",    // Default: .image-label
      label_default: "Choose File",   // Default: Choose File
      label_selected: "Change File",  // Default: Change File
      no_label: false,                // Default: false
      success_callback: null          // Default: null
    });
    var cleaveC = new Cleave('.currency', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
    });

    $('#table-stocks').DataTable({
      ajax: '<?= route('admin/products/'. $product->id .'/stocks') ?>',
      ordering: false,
      columns: [
        { data: "id" },
        { data: "activation_code" },
        { data: "created_at" },
        { data: "updated_at" }
      ]
    });

  });
  </script>

</body>
</html>