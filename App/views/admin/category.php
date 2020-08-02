<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', [
    'pageTitle' => 'Kategori',
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
            <h1>Kategori</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?= route('admin') ?>">Dashboard</a></div>
              <div class="breadcrumb-item">Kategori</div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card card-info">
                <div class="card-header">
                  <h4>Kategori</h4>
                  <div class="card-header-action">
                    <button class="btn btn-success" id="btnAddCategory"><i class="fa fa-plus-circle"></i> Tambah Kategori</button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-categories">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>Slug</th>
                          <th>Deskripsi</th>
                          <th>Gambar</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="false" id="modalCategory">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Form Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="<?= route('/admin/categories/update') ?>" id="formCategory">
                          <input type="hidden" name="id">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="name">Nama</label>
                              <input type="text" name="name" id="name" class="form-control" placeholder="Nama">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="name">Slug</label>
                              <input type="text" name="slug" id="slug" class="form-control" placeholder="slug">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" style="height: 100px" class="form-control"></textarea>
                          </div>
                          <div class="form-group">
                            <div id="image-preview" class="image-preview">
                              <label for="image-upload" id="image-label">Pilih Gambar</label>
                              <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg" id="image-upload" />
                            </div>
                          </div>
                          <div class="mb-3" id="img-section"></div>
                        </form>
                      </div>
                      <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" id="btnSave" class="btn btn-primary">Simpan</button>
                      </div>
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

  <?php importView('sections.dashboard.js', [
      'js' => [
          'modules/datatables/datatables.min.js',
          'modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
          'modules/upload-preview/assets/js/jquery.uploadPreview.min.js',
          'https://cdn.jsdelivr.net/npm/sweetalert2@9',
      ],
  ]) ?>

  <script>
  $(document).ready(function () {
    function shorten(text, max) {
      return text && text.length > max ? text.slice(0,max).split(' ').slice(0, -1).join(' ') : text
    }

    $.uploadPreview({
      input_field: "#image-upload",
      preview_box: "#image-preview",
      label_field: "#image-label",
      label_default: "Pilih Gambar",
      label_selected: "Ganti Gambar",
      no_label: false,
      success_callback: null
    });

    $('#btnAddCategory').on('click', function () {
      $('#formCategory').prop('action', '<?= route('/admin/categories/store') ?>');
      $('#modalCategory').modal('toggle');
    });

    const tableCategory = $('#table-categories').DataTable({
      ajax: '<?= route('admin/categories/api') ?>',
      columns: [
        { data: "id" },
        { data: "name" },
        { data: "slug" },
        {
          data: "description",
          render: function (val) {
            return shorten(val, 50) + '...'
          }
        },
        {
          data: "image",
          render: function (image) {
            return `<img class="img-thumbnail" src="<?= asset() ?>/${image}">`
          }
        },
        { 
          data: null,
          render: function (val, type, row) {
            return `<div class="btn-group"><button class="btn btn-danger btn-delete"><i class="fas fa-trash"></i> Delete</a>
            <button class="btn btn-warning btn-edit"><i class="fas fa-pen"></i> Edit</a></div>`
          }
        }
      ]
    });

    $('#table-categories tbody').on('click', '.btn-delete', function () {
      let data = tableCategory.row( $(this).parents('tr') ).data();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Kategori akan dihapus dan tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          $.post('<?= route('/admin/categories/delete') ?>', {id: data.id}, function () {
            Swal.fire('Sukses', 'Kategori berhasil dihapus!', 'success');
            tableCategory.ajax.reload();
          }).fail(function (err) {
            Swal.fire('Gagal!', 'Kategori gagal dihapus: ' + err, 'error');
          })
        }
      });
    });

    $('#table-categories tbody').on('click', '.btn-edit', function () {
      let data = tableCategory.row( $(this).parents('tr') ).data();
      fillModalForm(data);
      $('#formCategory').prop('action', '<?= route('/admin/categories/update') ?>');
      $('#modalCategory').modal('toggle');
    });

    $('#modalCategory').on('click', '#btnSave', function () {
      let data = new FormData();
      data.append('id', $('input[name=id]').val());
      data.append('name', $('#name').val());
      data.append('slug', $('#slug').val());
      data.append('description', $('textarea[name=description]').val());
      data.append('image', $('input[name=image]').prop('files')[0]);

      $.ajax({
        url: $('#formCategory').prop('action'), 
        data: data,
        type: 'POST',
        processData: false,
        contentType: false,
        success: function (data) {
          Swal.fire('Berhasil', data.message, 'success');
          $('#modalCategory').modal('toggle');
          tableCategory.ajax.reload();
        }
      });
    });

    $('#modalCategory').on('hide.bs.modal', function () {
      $('#img-section').empty();
      $('input[name=id]').val('');
      $('#name').val('');
      $('#slug').val('');
      $('textarea[name=description]').val('');
      $('#image-preview').prop('stlye', '');
    })

    function fillModalForm(data) {
      $('input[name=id]').val(data.id);
      $('input[name=name]').val(data.name);
      $('input[name=slug]').val(data.slug);
      $('textarea[name=description]').val(data.description);
      if (data.image != '') {
        $('<img />', {
          style: 'max-height: 150px',
          class: 'img-thumbnail',
          src: `<?= asset() ?>/${data.image}`
        }).appendTo('#img-section')
      }
    }
  });
  </script>

</body>
</html>