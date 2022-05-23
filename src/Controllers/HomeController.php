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

  /**
   * View create projetc
   * 
   * @return mixed
   */
  public function create(): mixed
  {
    return layout(
      view: 'layouts/app',
      content: 'create',
      data: ['title' => 'Add New Project']
    );
  }

  public function store(Request $request)
  {
    $projects = [
      [
        'name' => 'PHPMyAdmin',
        'description' => 'Database (MariaDB).',
        'url' => 'http://localhost/phpmyadmin/',
      ],
      [
        'name' => 'PHP MVC',
        'description' => 'Kerangka untuk pembuatan native php dengan metode mvc (model, view, controller).',
        'url' => 'http://localhost/php-mvc/',
      ],
      [
        'name' => 'Feelbuy Helpdesk',
        'description' => 'Feelbuy technology system.',
        'url' => 'http://localhost:8056/php-5/feelbuy-helpdesk/',
      ],
      [
        'name' => 'Slow Motor Inventory',
        'description' => 'Sistem infomasi manajemen stok suku cadang motor.',
        'url' => 'http://localhost/slow-motor-inventory/',
      ],
      [
        'name' => 'IO Dev',
        'description' => 'My portfolio web app.',
        'url' => 'https://iodev.vercel.app/',
      ],
    ];

    try {
      foreach ($projects as $project) {
        DB::table('projects')->insert($project);
      }

      Session::flash('alert', [
        'type' => 'success',
        'message' => 'Insert projects into database successfuly.',
      ]);
    } catch (PDOException $e) {
      Session::flash('alert', [
        'type' => 'danger',
        'message' => $e->getMessage(),
      ]);
    }

    return header('Location: ' . route('home/index'));
  }
}
