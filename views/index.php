<!-- Header -->
<div class="row">
	<div class="col-sm-12">
		<h1>Welcome to <?= e(config('app.name')); ?></h1>
		<p class="lead mb-0"><?= e(config('app.description')); ?></p>
	</div>
</div>

<hr class="my-5">

<div class="row">
	<div class="col-sm-12 col-md-4 col-lg-6 mb-4">
		<a href="<?= e(route('home/add')); ?>" class="btn btn-dark bg-gradient shadow-sm" role="button">
			<i class="bi bi-plus-lg me-1"></i>
			<span>Add New Project</span>
		</a>
	</div>

	<div class="col-sm-12 col-md-8 col-lg-6 mb-4">
		<form autocomplete="off" method="GET" action="<?= e(route('home/index')); ?>">
			<input type="hidden" name="route" value="home/index">

			<div class="input-group">
				<input type="search" name="search" id="search" value="<?= e($search); ?>" class="form-control" placeholder="Search projects...">
				<button type="submit" class="btn btn-outline-dark bg-gradient">
					<span>Search</span>
				</button>
			</div>
		</form>
	</div>
</div>

<!-- List project -->
<div class="row">
	<?php foreach ($projects as $project) : ?>
		<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
			<div class="card shadow-sm project">
				<a href="<?= e($project->url); ?>" target="_blank">
					<div class="card-body">
						<div class="mb-3 border-bottom">
							<h5 class="card-title d-inline-block text-truncate" style="max-width: 100%;">
								<?= e($project->name); ?>
							</h5>
						</div>

						<p class="project-description mb-0 fs-6 card-text">
							<?= e($project->description); ?>
						</p>
					</div>
				</a>

				<footer class="card-footer">
					<button type="button" onclick="handleDelete('<?= e(route('home/delete', ['id' => $project->id])); ?>')" class="btn btn-sm btn-dark bg-gradient shadow-sm" data-bs-toggle="tooltip" title="Delete">
						<i class="bi bi-trash"></i>
					</button>

					<a href="<?= e(route('home/edit', ['id' => $project->id])); ?>" class="btn btn-sm btn-dark bg-gradient shadow-sm ms-2" role="button" data-bs-toggle="tooltip" title="Edit">
						<i class="bi bi-pencil"></i>
					</a>
				</footer>
			</div>
		</div>
	<?php endforeach; ?>
</div>