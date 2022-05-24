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
    /**
     * Cek request http method
     */
    if ($request->method != 'POST') {
      return toRoute('home/add');
    }

    /**
     * variabel untuk menampung error
     * 
     * @var array
     */
    $validatedResponse = [];

    /**
     * Ambil url dari database untuk validasi.
     */
    $availableUrl = DB::table('projects')
      ->select('url')
      ->where('url', '=', $request->input->url)
      ->first();

    /**
     * Cek apakah url yang sama sudah digunakan atu belum.
     * Jika sidah berikan pesan error.
     */
    if ($availableUrl) {
      $validatedResponse['url'] = 'The same url is already in use.';
    }

    /**
     * Cek apa value dari nama kosong atau tidak.
     * Jika kosong berikan pesan error.
     */
    if (empty(trim($request->input->name))) {
      $validatedResponse['name'] = 'Project name is required';
    }

    /**
     * Cek jumlah pesan error.
     * 
     * Jika validasi gagal kembali ke halaman add project,
     * Serta kirimkan pesan error dan old value-nya.
     */
    if (count($validatedResponse) > 0) {
      Session::flash('old', (array) $request?->input);
      Session::flash('errors', $validatedResponse);

      return toRoute('home/add');
    }

    /**
     * Insert ke database jika semua validasi lolos.
     */
    try {
      DB::table('projects')->insert([
        'name' => $request->input->name,
        'url' => $request->input->url,
        'description' => $request->input->description,
      ]);
    } catch (\Throwable $th) {
      throw new PDOException($th->getMessage());
    }

    /**
     * Buat notifikasi insert data berhasil.
     */
    Session::flash('alert', [
      'type' => 'success',
      'message' => '1 new project added successfully.',
    ]);

    /**
     * Redirect ke halaman home
     */
    return toRoute('home/add');
  }

  /**
   * View phpinfo()
   * 
   * @return mixed
   */
  public function phpInfo(Request $request): mixed
  {
    /**
     * Default port
     * 
     * @var string
     */
    $port = '80';

    /**
     * Cek versi php yang di-request.
     */
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

    /**
     * Redirect & tampilkan phpinfo()
     */
    return header("Location: http://localhost:{$port}/phpinfo.php");
  }
}
