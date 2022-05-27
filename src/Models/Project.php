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

  public static function find(int $id)
  {
      return parent::table(self::$table)
        ->select()
        ->where('id', '=', $id)
        ->limit(1)
        ->first();
  }

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
      $query->whereFullText(['name', 'description'], $search);
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
      ->limit(1)
      ->get();
  }

  public static function insert(array $data)
  {
      return parent::table(self::$table)
        ->insert($data)
        ->run();
  }

  /**
   * Delete project
   * 
   * @param  int $id
   * 
   * @return int
   */
  public static function delete(string|int $id): int
  {
    return parent::table(name: self::$table)
      ->delete()
      ->where('id', '=', $id)
      ->run();
  }
}
