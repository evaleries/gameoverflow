<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

  <?php if (isset($pageTitle)) { ?>
    <title><?= $pageTitle ?> &mdash; GameOverflow</title>
  <?php } else { ?>
    <title>Dashboard &mdash; GameOverflow</title>
  <?php } ?>

  <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('apple-touch-icon.png') ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('favicon-32x32.png') ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('favicon-16x16.png') ?>">
  <link rel="manifest" href="<?= asset('site.webmanifest') ?>">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= asset('dashboard/modules/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('dashboard/modules/fontawesome/css/all.min.css') ?>">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= asset('dashboard/modules/owlcarousel2/dist/assets/owl.carousel.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('dashboard/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') ?>">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= asset('dashboard/css/style.css') ?>">
  <link rel="stylesheet" href="<?= asset('dashboard/css/components.css') ?>">

  <?php if (isset($css)) {
    foreach ($css as $c) { ?>

  <link rel="stylesheet" href="<?= !startsWith($c, 'http') ? asset('dashboard/'.$c) : $c ?>">

  <?php }
} ?>

</head>
