<?php

namespace Src\Models;

use Src\Database\DB;

/**
 * Model project class
 */
class Project extends DB
{
  /**
   * Nama tabel
   * 
   * @var string
   */
  protected static $table = 'projects';

  protected static $db;



  /**
   * Mengambil semua data project
   * 
   * @param Request $request
   * 
   * @return array
   */
  public static function findOrAll($request): array
  {
    $query = parent::table(self::$table);

    if ($request->input?->search) {
      $query->whereFullText(['description', 'name'], $request->input->search);
    } else {
      $query->select();
    }

    return $query->orderBy('name', 'asc')->get();
  }
}
