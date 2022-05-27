<!-- Header -->
<div class="row">
  <div class="col-12">
    <h1><?= e($title); ?></h1>

    <p class="lead mb-0">
      Edit project for main page
    </p>
  </div>
</div>

<hr class="my-5">

<div class="row">
  <div class="col-sm-12 col-md-8 order-2 order-md-1 mb-4">
    <form action="<?= e(route('home/update')); ?>" method="POST">
      <input type="hidden" name="id" value="<?= e($project->id); ?>">

      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="card-title">Form Edit Project</h5>

            <a href="<?= e(route('home/index')); ?>" class="btn btn-dark bg-gradient shadow-sm">
              <i class="bi bi-chevron-left me-1"></i>
              <span>Go Back</span>
            </a>
          </div>

          <hr class="mt-3 mb-4">

          <!-- Input project name -->
          <div class="row mb-4">
            <label for="name" class="col-md-4 col-sm-12 col-form-label">
              Project Name <small class="text-danger">*</small>
            </label>

            <div class="col-md-8 col-sm-12">
              <input type="text" name="name" id="name" class="form-control <?= !empty(errors('name')) ? 'is-invalid' : ''; ?>" value="<?= e(old('name', $project->name)); ?>" placeholder="Enter project name..." required />

              <?php if (!empty(errors('name'))) : ?>
                <small class="invalid-feedback">
                  <?= e(errors('name')); ?>
                </small>
              <?php endif; ?>
            </div>
          </div>

          <!-- Input project url -->
          <div class="row mb-4">
            <label for="url" class="col-md-4 col-sm-12 col-form-label">
              Project Url <small class="text-danger">*</small>
            </label>

            <div class="col-md-8 col-sm-12">
              <input type="text" name="url" id="url" class="form-control <?= !empty(errors('url')) ? 'is-invalid' : ''; ?>" value="<?= e(old('url', $project->url)); ?>" placeholder="Enter project url..." required />

              <?php if (!empty(errors('url'))) : ?>
                <small class="invalid-feedback">
                  <?= e(errors('url')); ?>
                </small>
              <?php endif; ?>
            </div>
          </div>

          <!-- Input project description -->
          <div class="row mb-4">
            <label for="description" class="col-md-4 col-sm-12 col-form-label">
              Project Description
            </label>

            <div class="col-md-8 col-sm-12">
              <textarea name="description" id="description" class="form-control <?= !empty(errors('description')) ? 'is-invalid' : ''; ?>" rows="5" placeholder="Enter project description..."><?= e(old('description', $project->description)); ?></textarea>

              <?php if (!empty(errors('description'))) : ?>
                <small class="invalid-feedback">
                  <?= e(errors('description')); ?>
                </small>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Card footer untuk button submit & reset -->
        <footer class="card-footer d-flex justify-content-end">
          <button type="submit" class="btn btn-success bg-gradient shadow-sm">
            <i class="bi bi-save me-1"></i>
            <span>Update Project</span>
          </button>

          <button type="reset" class="btn btn-secondary bg-gradient shadow-sm ms-2">
            <i class="bi bi-x-circle me-1"></i>
            <span>Reset</span>
          </button>
        </footer>
      </div>
    </form>
  </div>

  <div class="col-sm-12 col-md-4 order-1 order-md-2 mb-4">
    <div class="alert alert-info shadow-sm mb-0" role="alert">
      <h5 class="alert-heading">Info</h5>
      <hr>
      <p class="mb-0">Form with (<small class="text-danger">*</small>) is required.</p>
    </div>
  </div>
</div>