<?php

use Src\Http\Request;
use Src\Http\Response;
use Src\Models\Project;
use Src\Core\Controller;

/**
 * Home Controller
 */
class HomeController extends Controller
{
  /**
   * View home page
   * 
   * @return
   */
  public function index(Request $request): mixed
  {
    $search = "";

    if (isset($request->input->search) && !empty($request->input->search)) {
      $search = $request->input->search;
    }

    return layout(
      view: 'layouts/app',
      content: 'index',
      data: [
        'title' => 'Home',
        'projects' => Project::findOrAll($search),
        'search' => $search,
        'scripts' => ['/assets/js/pages/home.js'],
      ],
    );
  }

  /**
   * View create projetc
   * 
   * @return mixed
   */
  public function add(): mixed
  {
    return layout(
      view: 'layouts/app',
      content: 'add',
      data: ['title' => 'Add New Project']
    );
  }

  /**
   * Insert 1 row ke database
   * 
   * @param Request $request
   * 
   * @return mixed
   */
  public function store(Request $request): mixed
  {
    // Cek request http method.
    // Jika method bukan POST redirect ke halaman home.
    if ($request->method != 'POST') {
      return Response::toRoute('home/index');
    }

    // variabel untuk menampung error
    $validatedResponse = [];

    // Validasi apa value dari nama kosong atau tidak.
    if (empty(trim($request->input->name))) {
      $validatedResponse['name'] = 'Project name is required';
    }

    // Validasi ukuran panjang name
    if (strlen($request->input->name) > 100) {
      $validatedResponse['name'] = 'The project name cannot be longer than 100 characters.';
    }

    // Validasi apakah url yang sama sudah digunakan atu belum.
    if (Project::availableUrl($request->input->url)) {
      $validatedResponse['url'] = 'The same url is already in use.';
    }

    // Validasi ukuran panjang url
    if (strlen($request->input->url) > 100) {
      $validatedResponse['url'] = 'Url cannot be more than 100 characters.';
    }

    // Cek jumlah pesan error.
    // Jika validasi gagal kembali ke halaman add project,
    // Serta kirimkan pesan error dan old value-nya.
    if (count($validatedResponse) > 0) {
      return Response::toRoute('home/add')
        ->withFlash('errors', $validatedResponse)
        ->withOldInput((array) $request?->input);
    }

    $data['name'] = $request->input->name;
    $data['url'] = $request->input->url;

    if (!empty($request->input->description)) {
      $data['description'] =  $request->input->description;
    }

    // Insert ke database jika semua validasi lolos.
    try {
      Project::insert($data);
    } catch (\Throwable $th) {
      throw new PDOException($th->getMessage());
    }

    // Redirect ke halaman home.
    // Serta kirimkan alert insert data berhasil.
    return Response::toRoute('home/add')->withFlash('alert', [
      'type' => 'success',
      'message' => 'New project added successfully.',
    ]);
  }

  /**
   * Delete project
   * 
   * @param  Request $request
   * 
   * @return mixed
   */
  public function delete(Request $request): mixed
  {
    // Cek apakah id dikirim atau tidak
    if (!isset($request->input->id) || empty($request->input->id)) {
      return Response::toRoute('home/index');
    }

    // Proses delete
    try {
      if (Project::delete($request->input->id) <= 0) {
        Response::toRoute('home/index')->withFlash('alert', [
          'type' => 'warning',
          'message' => "Project with id {$request->input->id} not found.",
        ]);
      }
    } catch (Exception $e) {
      return Response::toRoute('home/index')->withFlash('alert', [
        'type' => 'danger',
        'message' => 'Project failed to delete',
      ]);
    }

    // Response jika proses delete berhasil
    return Response::toRoute('home/index')
      ->withFlash('alert', [
        'type' => 'success',
        'message' => 'Project deleted successfully.',
      ]);
  }

  /**
   * View edit project
   * 
   * @param Request $request
   * 
   * @return mixed
   */
  public function edit(Request $request): mixed
  {
    // Cek id direquest atau tidak
    if (!isset($request->input->id) || empty($request->input->id)) {
      return Response::toRoute('home/index')->withFlash('alert', [
        'type' => 'danger',
        'message' => 'Project not found!'
      ]);
    }

    // Ambil data project
    $project = Project::find($request->input->id);

    // Cek apakah hasil query ada atau kosong
    if (!$project) {
      return Response::toRoute('home/index')->withFlash('alert', [
        'type' => 'danger',
        'message' => 'Project not found!'
      ]);
    }

    // view layout
    return layout(
      view: 'layouts/app',
      content: 'edit',
      data: [
        'title' => 'Edit Project',
        'project' => $project,
      ]
    );
  }

  /**
   * Update project
   * 
   * @param Request $request
   * 
   * @return
   */
  public function update(Request $request)
  {
    // Jika method bukan POST redirect ke halaman home.
    if ($request->method != 'POST') {
      return Response::toRoute('home/index');
    }

    // Cek id direquest atau tidak
    if (!isset($request->input->id) || empty($request->input->id)) {
      return Response::toRoute('home/index')->withFlash('alert', [
        'type' => 'danger',
        'message' => 'Project not found!'
      ]);
    }

    // variabel untuk menampung error
    $validatedResponse = [];

    // Validasi apa value dari nama kosong atau tidak.
    if (empty(trim($request->input->name))) {
      $validatedResponse['name'] = 'Project name is required';
    }

    // Validasi ukuran panjang name
    if (strlen($request->input->name) > 100) {
      $validatedResponse['name'] = 'The project name cannot be longer than 100 characters.';
    }

    // Validasi apakah url yang sama sudah digunakan atu belum.
    if (Project::checkUrlForUpdate($request->input->url, $request->input->id)) {
      $validatedResponse['url'] = 'The same url is already in use.';
    }

    // Validasi ukuran panjang url
    if (strlen($request->input->url) > 100) {
      $validatedResponse['url'] = 'Url cannot be more than 100 characters.';
    }

    // Cek jumlah pesan error.
    // Jika validasi gagal kembali ke halaman add project,
    // Serta kirimkan pesan error dan old value-nya.
    if (count($validatedResponse) > 0) {
      return Response::toRoute('home/edit', ['id' => $request->input->id])
        ->withFlash('errors', $validatedResponse)
        ->withOldInput((array) $request?->input);
    }

    $data['name'] = $request->input->name;
    $data['url'] = $request->input->url;

    if (!empty($request->input->description)) {
      $data['description'] =  $request->input->description;
    }

    // Insert ke database jika semua validasi lolos.
    try {
      Project::update($data, $request->input->id);
    } catch (\Throwable $th) {
      throw new PDOException($th->getMessage());
    }

    // Redirect ke halaman home.
    // Serta kirimkan alert insert data berhasil.
    return Response::toRoute('home/index')->withFlash('alert', [
      'type' => 'success',
      'message' => 'Project updated successfully.',
    ]);
  }

  /**
   * View phpinfo()
   * 
   * @return mixed
   */
  public function phpInfo(Request $request): mixed
  {
    // Default port
    $port = '80';

    // Cek versi php yang di-request.
    switch ($request->input->version) {
      case '5.6':
        $port = '8056';
        break;

      case '7.4':
        $port = '8074';
        break;

      default:
        $port = '80';
        break;
    }

    return header("Location: http://localhost:{$port}/phpinfo.php");
  }
}
