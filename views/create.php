<!-- Header -->
<div class="row">
  <div class="col-12">
    <h1><?php e($title); ?></h1>
  </div>
</div>

<hr class="my-5">

<div class="row">
  <div class="col-sm-12 col-md-8 order-2 order-md-1 mb-4">
    <form action="">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Form Add</h5>

          <hr class="mt-3 mb-4">

          <div class="row mb-4">
            <label for="name" class="col-md-4 col-sm-12 col-form-label">
              Project Name <small class="text-danger">*</small>
            </label>
            
            <div class="col-md-8 col-sm-12">
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter project name...">
            </div>
          </div>

          <div class="row mb-4">
            <label for="url" class="col-md-4 col-sm-12 col-form-label">
              Project Url <small class="text-danger">*</small>
            </label>
            
            <div class="col-md-8 col-sm-12">
              <input type="text" name="url" id="url" class="form-control" placeholder="Enter project url...">
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="col-sm-12 col-md-4 order-1 order-md-2 mb-4">
    <div class="alert alert-info shadow-sm mb-0" role="alert">
      <h4 class="alert-heading">Info</h4>
      <hr>
      <p class="mb-0">Form with (*) is required.</p>
    </div>
  </div>
</div>