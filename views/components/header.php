<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark text-light bg-gradient border-bottom shadow-sm py-3">
  <div class="container">
    <a class="navbar-brand" href="<?= route('home/index') ?>">
      <?= config('app.name'); ?>
    </a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarHeader">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarHeader">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-bs-toggle="dropdown">
            PHP Info
          </a>

          <ul class="dropdown-menu shadow">
            <li>
              <a class="dropdown-item" href="<?= route('home/phpInfo', ['version' => '8.1']); ?>" target="_blank">
                PHP v8.1
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="<?= route('home/phpInfo', ['version' => '7.4']); ?>" target="_blank">
                PHP v7.4
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="<?= route('home/phpInfo', ['version' => '5.6']); ?>" target="_blank">
                PHP v5.6
              </a>
            </li>
          </ul>
        </li>
      </ul>

      <div class="d-flex">
        <span>v<?= config('app.version'); ?></span>
      </div>
    </div>
  </div>
</nav>