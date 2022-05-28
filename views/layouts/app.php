<?php

use Src\Session\Flash;
use Src\Views\Header;

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= config('app.description'); ?>">
  <meta name="base-url" content="<?= e(url('/')) ?>">

  <!-- Title -->
  <title><?= $title . ' - ' . config('app.name'); ?></title>

  <!-- Icon -->
  <link rel="shortcut icon" href="<?= url('/favicon.png'); ?>" type="image/x-icon">

  <!-- CSS -->
  <link rel="stylesheet" href="<?= url('/assets/css/app.css'); ?>">
</head>

<body>
  <?php Header::render() ?>

  <!-- Notifikasi alert -->
  <?php if (Flash::get('alert')) : ?>
    <div class="alert alert-<?= e(Flash::get('alert')->type); ?> alert-dismissible fade show shadow-sm my-0 " style="border-radius: 0;">
      <button class="btn-close" data-bs-dismiss="alert"></button>

      <p class="mb-0">
        <?= e(Flash::get('alert')->message); ?>
      </p>
    </div>
  <?php endif; ?>

  <!-- Content -->
  <div class="container py-5">
    <?php require __DIR__ . "/../../views/{$content}.php"; ?>
  </div>

  <!-- JS -->
  <script type="module" src="<?= url('/assets/js/globals.js') ?>"></script>

  <!-- Oteher JS -->
  <?php if (isset($scripts)) : ?>
    <?php foreach ($scripts as $script) : ?>
      <script type="module" src="<?= e(url($script)); ?>"></script>
    <?php endforeach; ?>
  <?php endif; ?>
</body>

</html>