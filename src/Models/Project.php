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

  /**
   * Mengambil semua data project
   * 
   * @param Request $request
   * 
   * @return array
   */
  public static function findOrAll($search): array
  {
    $query = parent::table(self::$table)->select();

    if (!empty($search)) {
      $query->whereFullText(['description', 'name'], $search);
    }

    return $query->orderBy('name', 'asc')->get();
  }

  /**
   * Cek apakah url ada atau sudah digunakan
   * 
   * @param string $url
   * 
   * @return mixed
   */
  public static function availableUrl(string $url): mixed
  {
    return parent::table(self::$table)
      ->select('url')
      ->where('url', '=', $url)
      ->first();
  }
}
