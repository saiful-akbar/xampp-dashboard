<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= config('app.description'); ?>">

  <!-- Title -->
  <title><?= $title . ' - ' . config('app.name'); ?></title>

  <!-- Icon -->
  <link rel="shortcut icon" href="<?= url('/favicon.png') ?>" type="image/x-icon">

  <!-- CSS -->
  <link rel="stylesheet" href="<?= url('/assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= url('/assets/css/app.css'); ?>">
</head>

<body>
  <?php \Src\Views\Header::render() ?>

  <!-- Content -->
  <div class="container py-4">
    <?php require __DIR__ . "/../../views/{$content}.php"; ?>
  </div>

  <!-- JS -->
  <script src="<?= url('/assets/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= url('/assets/js/app.js') ?>"></script>
</body>

</html>