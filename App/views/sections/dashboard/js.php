<!-- General JS Scripts -->
<script src="<?= asset('dashboard/modules/jquery.min.js') ?>"></script>
<script src="<?= asset('dashboard/modules/popper.js') ?>"></script>
<script src="<?= asset('dashboard/modules/tooltip.js') ?>"></script>
<script src="<?= asset('dashboard/modules/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= asset('dashboard/modules/nicescroll/jquery.nicescroll.min.js') ?>"></script>
<script src="<?= asset('dashboard/modules/moment.min.js') ?>"></script>
<script src="<?= asset('dashboard/js/stisla.js') ?>"></script>

<!-- JS Libraies -->
<script src="<?= asset('dashboard/modules/jquery.sparkline.min.js') ?>"></script>
<script src="<?= asset('dashboard/modules/chart.min.js') ?>"></script>
<script src="<?= asset('dashboard/modules/owlcarousel2/dist/owl.carousel.min.js') ?>"></script>
<script src="<?= asset('dashboard/modules/summernote/summernote-bs4.js') ?>"></script>
<script src="<?= asset('dashboard/modules/chocolat/dist/js/jquery.chocolat.min.js') ?>"></script>

<!-- Template JS File -->
<script src="<?= asset('dashboard/js/scripts.js') ?>"></script>

<?php if (isset($js)): foreach($js as $j): ?>
    <script src="<?= (! startsWith($j, 'http')) ? asset('dashboard/'. $j) : $j ?>"></script>
<?php endforeach; endif; ?>
