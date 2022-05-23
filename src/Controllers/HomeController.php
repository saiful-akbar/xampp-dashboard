<?php

use Src\Database\DB;
use Src\Core\Controller;
use Src\Http\Request;
use Src\Http\Session;
use Src\Models\Project;

class HomeController extends Controller
{
  /**
   * View home page
   * 
   * @return
   */
  public function index(Request $request)
  {
    $search = null;

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
    // Cek method
    if ($request->method != 'POST') {
      header('Location: ' . route('home/create'));
    }

    // Varibel untuk menampung error
    $errors = [];

    // Ambil url dari database
    $availableUrl = DB::table('projects')
      ->select('url')
      ->where('url', '=', $request->input->url)
      ->first();

    // Cek apakah url sudah digunakan atau belum.
    // Jika sudah digunakan tambahkan errors
    if ($availableUrl) {
      $errors['url'] = 'The same url is already in use.';
    }

    // Cek apakah nama kosong atau tidak
    // Jika kosong tambahkan errors
    if (empty(trim($request->input->name))) {
      $errors['name'] = 'Project name is required';
    }

    // Kembali ke halaman create project
    // Serta kirimkan pesan error & old value-nya
    if (count($errors) > 0) {
      Session::flash('old', (array) $request?->input);
      Session::flash('errors', $errors);

      return header('Location: ' . route('home/add'));
    }

    // Insert ke database jika semua validasi lolos
    try {
      DB::table('projects')->insert([
        'name' => $request->input->name,
        'url' => $request->input->url,
        'description' => $request->input->description,
      ]);
    } catch (\Throwable $th) {
      throw new PDOException($th->getMessage());
    }

    // Set session flash success
    Session::flash('alert', [
      'type' => 'success',
      'message' => '1 new project added successfully.',
    ]);

    // redirect ke halaman home
    return header('Location: ' . route('home/add'));
  }

  /**
   * View phpinfo()
   * 
   * @return void
   */
  public function phpInfo(Request $request): void
  {
    $port = '80';

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

    header("Location: http://localhost:{$port}/phpinfo.php");
    exit();
  }
}
