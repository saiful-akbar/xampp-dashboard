<?php

use Src\Core\Controller;
use Src\Http\Request;
use Src\Models\Project;

class HomeController extends Controller
{
  /**
   * View home page
   * 
   * @return
   */
  public function index()
  {
    $title = 'Home';
    $projects = Project::all();

    return layout(
      view: 'layouts.app',
      content: 'home',
      data: compact('title', 'projects'),
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
}
