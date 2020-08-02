<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', ['pageTitle' => 'Detail Pesanan', 'css' => ['https://printjs-4de6.kxcdn.com/print.min.css']]) ?>

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
              <a href="<?= route('admin/orders') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Detail Pesanan</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?= route('admin') ?>">Dashboard</a></div>
              <div class="breadcrumb-item active"><a href="<?= route('admin/orders') ?>">Pesanan</a></div>
              <div class="breadcrumb-item">Detail Pesanan</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Detail Pesanan #<?= $order->id ?> | Status: <span class="badge badge-<?= $order->determineStatusClass() ?>"><?= $order->getStatusString() ?></span></h4>
                    <div class="card-header-action">
                      <a data-collapse="#order-detail" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                  </div>
                  <div class="card-body collapse show" id="order-detail">
                    <div class="form-group">
                      <label for="user_name">Nama</label>
                      <input type="text" class="form-control" value="<?= $user->name ?>" disabled>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="bank_name">Nama Bank</label>
                        <input type="text" class="form-control" value="<?= $payment->bank_name ?>" disabled>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="bank_name">No Rekening</label>
                        <input type="text" class="form-control" value="<?= $payment->bank_number ?>"disabled>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="amount">Total Pembayaran</label>
                        <input type="text" class="form-control" value="<?= $payment->formattedAmount() ?>" disabled>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="order_created_at">Tanggal Pesanan</label>
                        <input type="text" class="form-control" value="<?= $order->created_at ?>" disabled>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="payment_status">Status Pembayaran</label>
                        <input type="text" class="form-control" value="<?= $payment->getPaymentStatus() ?>" disabled>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="due_date">Jatuh Tempo</label>
                        <input type="text" class="form-control" value="<?= $invoice->due_date ?>" disabled>
                      </div>
                    </div>
                    <?php if ($order->description) { ?>
                    <div class="form-group">
                      <label for="description">Deskripsi Pesanan</label>
                      <input type="text" name="description" id="order_description" class="form-control" value="<?= $order->description ?>" disabled>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="invoice">
              <div class="invoice-print" id="invoiceRoot">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2>Pesanan #<?= $order->id ?></h2>
                      <div class="invoice-number">Tagihan #<?= $invoice->no ?></div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Ditagih ke:</strong><br>
                            <?= $user->name ?><br>
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Jatuh Tempo:</strong><br>
                          <?= $invoice->due_date ?>
                        </address>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Metode Pembayaran:</strong><br>
                          <?= $payment->bank_name ?> | No. <?= $payment->bank_number ?><br>
                          A/N. <?= $user->name ?>
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Tanggal Pesanan:</strong><br>
                          <?= $order->created_at ?><br><br>
                        </address>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">Ringkasan Pesanan</div>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                          <th data-width="40"></th>
                          <th>Barang</th>
                          <th class="text-center">Harga</th>
                          <th class="text-center">Jumlah</th>
                          <th class="text-right">Total</th>
                        </tr>
                        <?php $total = 0; $i = 1; foreach ($orderItems as $item) { ?>
                        <tr>
                          <th data-width="40"><?= $i ?></th>
                          <th><?= $item->title ?></th>
                          <th class="text-center">Rp <?= number_format($item->price, 0, ',', '.')  ?>,-</th>
                          <th class="text-center"><?= $item->quantity ?></th>
                          <th class="text-right">Rp <?= number_format($item->quantity * $item->price, 0, ',', '.') ?>,-</th>
                        </tr>
                        <?php $total += $item->quantity * $item->price; $i++; } ?>
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Pembayaran</div>
                        <?php if ($payment->status == \App\Models\Payment::CONFIRMED) { ?>
                          <p class="section-lead">Pembayaran sudah dikonfirmasi pada tanggal <?= $payment->getUpdatedAtFormat('j F Y H:i A') ?></p>
                        <?php } else { ?>
                          <p class="section-lead">Pembayaran harus dilakukan sebelum tanggal jatuh tempo.</p>
                        <?php } ?>
                      </div>
                      <div class="col-lg-4 text-right">
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value invoice-detail-value-lg">Rp <?= number_format($total, 0, ',', '.') ?>,-</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                  <button id="btn-confirm" class="btn btn-success btn-confirm btn-icon <?= $order->status == 3 || $order->status == 2 ? 'disabled' : '' ?> icon-left" <?= $order->status == 3 || $order->status == 2 ? 'disabled' : '' ?>><i class="fas fa-check"></i> Konfirmasi</button>
                  <button id="btn-cancel" class="btn btn-danger btn-cancel btn-icon <?= $order->status == 3 || $order->status == 2 ? 'disabled' : '' ?> icon-left" <?= $order->status == 3 || $order->status == 2 ? 'disabled' : '' ?>><i class="fas fa-times"></i> Batalkan</button>
                </div>
                <button class="btn btn-warning btn-icon icon-left" onclick="printJS('invoiceRoot', 'html')"><i class="fas fa-print"></i> Print</button>
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
          'https://printjs-4de6.kxcdn.com/print.min.js',
          'https://cdn.jsdelivr.net/npm/sweetalert2@9',
      ],
  ]) ?>

  <script>
  $(document).ready(function (e) {
    $('#btn-confirm').on('click', async function (e) {
      const { value: accept } = await Swal.fire({
        title: 'Konfirmasi Pembayaran',
        input: 'checkbox',
        icon: 'warning',
        inputValue: 0,
        showCancelButton: true,
        focusCancel: true,
        inputPlaceholder:
          'Saya sudah menerima pembayaran dengan jumlah yang sudah tertera',
        confirmButtonText:
          'Konfirmasi <i class="fas fa-check"></i>',
        inputValidator: (result) => {
          return !result && 'Anda harus memastikan pembayaran sudah diterima'
        }
      })

      if (accept) {
        $.post('<?= route('admin/orders/'.$order->id.'/confirm') ?>', {id: '<?= $order->id ?>'}, function (data) {
          if (data.status) {
            Swal.fire('Sukses!', 'Pesanan sudah terkonfirmasi, kode aktivasi akan dikirim ke akun pengguna.', 'success');
            setTimeout(() => {
              window.location.reload();
            }, 3000);
          } else {
            Swal.fire('Gagal!', data.message, 'error');
          }
        }).fail(function (err) {
          Swal.fire('Gagal!', 'Pesanan gagal terkonfirmasi', 'error');
        })
      }
    });

    $('#btn-cancel').on('click', async function (e) {
      const { value: accept } = await Swal.fire({
        title: 'Konfirmasi Pembatalan',
        input: 'checkbox',
        icon: 'warning',
        inputValue: 0,
        focusCancel: true,
        showCancelButton: true,
        inputPlaceholder:
          'Saya yakin membatalkan pesanan ini',
        confirmButtonColor: '#d33',
        reverseButtons: true,
        confirmButtonText:
          'Batalkan <i class="fas fa-times"></i>',
        inputValidator: (result) => {
          return !result && 'Anda harus mengkonfirmasi untuk menghapus pesanan ini'
        }
      })

      if (accept) {
        $.post('<?= route('admin/orders/'.$order->id.'/cancel') ?>', {id: '<?= $order->id ?>'}, function (data) {
          if (data.status) {
            Swal.fire('Sukses!', 'Pesanan sudah dibatalkan.', 'success');
            setTimeout(() => {
              window.location.reload();
            }, 3000);
          } else {
            Swal.fire('Gagal!', data.message, 'error');
          }
        }).fail(function (err) {
          Swal.fire('Gagal!', 'Pesanan gagal dibatalkan', 'error');
        })
      }
    });
  });
  </script>

</body>
</html>