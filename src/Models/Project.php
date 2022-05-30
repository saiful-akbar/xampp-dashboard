<?php

namespace Src\Models;

use Src\Database\DB;
use stdClass;

/**
 * Model project class
 */
class Project extends DB
{
  /**
   * Nama tabel
   * 
   * @var int|string
   */
  protected static $table = 'projects';

  /**
   * Find project
   * 
   * @param int|string $id
   * 
   * @return mixed
   */
  public static function find(int|string $id): mixed
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
   * @return array
   */
  public static function availableUrl(string $url): array
  {
    return parent::table(self::$table)
      ->select('url')
      ->where('url', '=', $url)
      ->limit(1)
      ->get();
  }

  /**
   * Insert project
   * 
   * @param array $data
   * 
   * @return int
   */
  public static function insert(array $data): int
  {
    return parent::table(self::$table)->insert($data)->run();
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

  /**
   * Check url for update
   * 
   * @param string $url
   * @param string $id
   * 
   * @return mixed
   */
  public static function checkUrlForUpdate(string $url, int|string $id): mixed
  {
    return parent::table(self::$table)
      ->select('url')
      ->where('url', '=', $url)
      ->andWhere('id', '!=', $id)
      ->first();
  }

  /**
   * Update project
   * 
   * @param array $data
   * @param string $id
   * 
   * @return mixed
   */
  public static function update(array $data, int|string $id): int
  {
      return parent::table(self::$table)
      ->update($data)
      ->where('id', '=', $id)
      ->run();
  }
}
