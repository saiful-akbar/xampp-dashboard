<!-- Header -->
<div class="row">
  <div class="col-12">
    <h1>Welcome to <?= config('app.name'); ?></h1>
    <p class="lead mb-0"><?= config('app.description'); ?></p>
  </div>
</div>

<hr class="my-5">

<!-- List project -->
<div class="row">
  <?php foreach ($projects as $project) : ?>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <a href="<?php e($project->url); ?>" target="_blank" class="project">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="mb-3 border-bottom">
              <h5 class="card-title d-inline-block text-truncate" style="max-width: 100%;">
                <?php e($project->name); ?>
              </h5>
            </div>

            <p class="project-description mb-0 fs-6 card-text">
              <?php e($project->description); ?>
            </p>
          </div>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
</div>