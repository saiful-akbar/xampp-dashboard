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
   * Mengambil data sebagai object
   * 
   * @return object
   */
  public static function all(): array
  {
    return parent::table(self::$table)
      ->select()
      ->orderBy('name', 'asc')
      ->get();
  }
}
