<head>
    <meta charset="UTF-8">
    <meta name="description" content="<?= isset($pageMeta['description']) ? $pageMeta['description'] : 'Gameoverflow best selling games platform' ?>">
    <meta name="keywords" content="<?= isset($pageMeta['keywords']) ? implode(', ', $pageMeta['keywords']) : 'gameoverflow, game' ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php if (isset($pageTitle)): ?>
        <title><?= $pageTitle ?> - GameOverFlow</title>
    <?php else: ?>
        <title>GameOverFlow</title>
    <?php endif; ?>

    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= asset('site.webmanifest') ?>">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?= asset('css/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= asset('css/font-awesome.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= asset('css/elegant-icons.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= asset('css/nice-select.css ') ?>" type="text/css">
    <link rel="stylesheet" href="<?= asset('css/jquery-ui.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= asset('css/owl.carousel.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= asset('css/slicknav.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>" type="text/css">
</head>
