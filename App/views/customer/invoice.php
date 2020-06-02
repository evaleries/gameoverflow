<!DOCTYPE html>
<html lang="en">

<?php importView('sections.dashboard.head', ['pageTitle' => 'Invoice', 'css' => ['https://printjs-4de6.kxcdn.com/print.min.css']]) ?>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
    
      <?php importView('sections.dashboard.nav-customer') ?>

      <?php importView('sections.dashboard.menu-customer') ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Tagihan</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="<?= route('customer') ?>">Dashboard</a></div>
              <div class="breadcrumb-item">Tagihan #<?= $invoice->no ?></div>
            </div>
          </div>

          <div class="section-body">
            <div class="invoice">
              <div class="invoice-print" id="invoiceRoot">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2>Tagihan #<?= $invoice->no ?></h2>
                      <div class="invoice-number">Pesanan #<?= $invoice->order_id ?></div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Ditagih ke:</strong><br>
                            <?= auth()->name ?><br>
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Batas Tanggal:</strong><br>
                          <?= $invoice->due_date ?>
                        </address>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Metode Pembayaran:</strong><br>
                          <?= $invoice->bank_name ?> | No. <?= $invoice->bank_number ?><br>
                          A/N. <?= auth()->name ?>
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Tanggal Pesanan:</strong><br>
                          <?= dt($invoice->order_date, 'Y-m-d H:i:s', 'j F Y') ?><br><br>
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
                        <?php $total = 0; $i = 1; foreach($orderItems as $item): ?>
                        <tr>
                          <th data-width="40"><?= $i ?></th>
                          <th><?= $item->product_title ?></th>
                          <th class="text-center">Rp <?= number_format($item->price, 0, ',', '.')  ?>,-</th>
                          <th class="text-center"><?= $item->quantity ?></th>
                          <th class="text-right">Rp <?= number_format($item->quantity * $item->price, 0, ',', '.') ?>,-</th>
                        </tr>
                        <?php $total += $item->quantity * $item->price; $i++; endforeach; ?>
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Pembayaran</div>
                        <?php if ($payment->status == \App\Models\Payment::CONFIRMED): ?>
                          <p class="section-lead">Pembayaran sudah dikonfirmasi pada tanggal <?= $payment->getUpdatedAtFormat('j F Y H:i A') ?></p>
                        <?php else: ?>
                          <p class="section-lead">Pembayaran harus dilakukan sebelum tanggal jatuh tempo.</p>
                        <?php endif; ?>
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
                <!-- <div class="float-lg-left mb-lg-0 mb-3">
                  <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process Payment</button>
                  <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
                </div> -->
                <button class="btn btn-warning btn-icon icon-left" onclick="printJS('invoiceRoot', 'html')"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </section>
      </div>

    
      <?php importView('sections.dashboard.footer') ?>
    </div>
  </div>

  <?php importView('sections.dashboard.js', ['js' => ['https://printjs-4de6.kxcdn.com/print.min.js']]) ?>

</body>
</html>