<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', [
  'pageTitle' => 'Developer',
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
            <h1>Developer</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?= route('admin') ?>">Dashboard</a></div>
              <div class="breadcrumb-item">Developer</div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card card-info">
                <div class="card-header">
                  <h4>Developer</h4>
                  <div class="card-header-action">
                    <button class="btn btn-success" id="btnAddDeveloper"><i class="fa fa-plus-circle"></i> Tambah Developer</button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-developers">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>Website</th>
                          <th>Deskripsi</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" data-backdrop="false" id="modalDeveloper">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Form Developer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="<?= route('/admin/developers/update') ?>" id="formDeveloper">
                          <input type="hidden" name="id">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="name">Nama</label>
                              <input type="text" name="name" id="name" class="form-control" placeholder="Nama">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="name">Website</label>
                              <input type="text" name="website" id="website" class="form-control" placeholder="http://valve.com">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" style="height: 100px" class="form-control"></textarea>
                          </div>
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
      'https://cdn.jsdelivr.net/npm/sweetalert2@9'
    ]
  ]) ?>

  <script>
  $(document).ready(function () {


    $('#btnAddDeveloper').on('click', function () {
      $('#formDeveloper').prop('action', '<?= route('/admin/developers/store') ?>');
      $('#modalDeveloper').modal('toggle');
    });

    const tableDeveloper = $('#table-developers').DataTable({
      ajax: '<?= route('admin/developers/api') ?>',
      columns: [
        { data: "id" },
        { data: "name" },
        { data: "website" },
        { data: "description" },
        { 
          data: null,
          render: function (val, type, row) {
            return `<div class="btn-group"><button class="btn btn-danger btn-delete"><i class="fas fa-trash"></i> Delete</a>
            <button class="btn btn-warning btn-edit"><i class="fas fa-pen"></i> Edit</a></div>`
          }
        }
      ]
    });

    $('#table-developers tbody').on('click', '.btn-delete', function () {
      let data = tableDeveloper.row( $(this).parents('tr') ).data();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Developer akan dihapus dan tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          $.post('<?= route('/admin/developers/delete') ?>', {id: data.id}, function () {
            Swal.fire('Sukses', 'Developer berhasil dihapus!', 'success');
            tableDeveloper.ajax.reload();
          }).fail(function (err) {
            Swal.fire('Gagal!', 'Developer gagal dihapus: ' + err, 'error');
          })
        }
      });
    });

    $('#table-developers tbody').on('click', '.btn-edit', function () {
      let data = tableDeveloper.row( $(this).parents('tr') ).data();
      fillModalForm(data);
      $('#formDeveloper').prop('action', '<?= route('/admin/developers/update') ?>');
      $('#modalDeveloper').modal('toggle');
    });

    $('#modalDeveloper').on('click', '#btnSave', function () {
      $.ajax({
        url: $('#formDeveloper').prop('action'), 
        data: $('#formDeveloper').serialize(),
        type: 'POST',
        success: function (data) {
          Swal.fire('Berhasil', data.message, 'success');
          $('#modalDeveloper').modal('toggle');
          tableDeveloper.ajax.reload();
        }
      });
    });

    $('#modalDeveloper').on('hide.bs.modal', function () {
      $('#img-section').empty();
      $('input[name=id]').val('');
      $('#name').val('');
      $('#website').val('');
      $('textarea[name=description]').val('');
      $('#image-preview').prop('style', '');
    })

    function fillModalForm(data) {
      $('input[name=id]').val(data.id);
      $('input[name=name]').val(data.name);
      $('input[name=website]').val(data.website);
      $('textarea[name=description]').val(data.description);
    }
  });
  </script>

</body>
</html>