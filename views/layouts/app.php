<?php

use Src\Http\Session;
use Src\Views\Header;

?>

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
  <?php Header::render() ?>

  <!-- Notifikasi alert -->
  <?php if (Session::getFlash('alert')) : ?>
    <div class="alert alert-<?php e(Session::getFlash('alert')->type) ?> alert-dismissible fade show shadow-sm my-0 " style="border-radius: 0;">
      <button class="btn-close" data-bs-dismiss="alert"></button>

      <p class="mb-0">
        <?php e(Session::getFlash('alert')->message); ?>
      </p>
    </div>
  <?php endif; ?>

  <!-- Content -->
  <div class="container py-5">
    <?php require __DIR__ . "/../../views/{$content}.php"; ?>
  </div>

  <!-- JS -->
  <script src="<?= url('/assets/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= url('/assets/js/app.js') ?>"></script>
</body>

</html>