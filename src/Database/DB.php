<?php

namespace Src\Database;

use Src\Database\SqlQueryBuilder;

/**
 * Database DB class
 */
class DB
{
  /**
   * SQL Query builder
   * 
   * @var SqlQueryBuilder|null|null
   */
  public static ?SqlQueryBuilder $builder = null;

  /**
   * Constructor
   */
  function __construct()
  {
    self::setBuilder();
  }

  /**
   * Set properti builder dengan class SqlQueryBuilder
   * 
   * @return SqlQueryBuilder
   */
  protected static function setBuilder(): SqlQueryBuilder
  {
    if (is_null(self::$builder)) {
      self::$builder = new SqlQueryBuilder();
    }

    return self::$builder;
  }

  /**
   * Set tabel database
   * 
   * @param string $table
   * 
   * @return SqlQueryBuilder
   */
  public static function table(string $table): SqlQueryBuilder
  {
    self::setBuilder();
    self::$builder->table($table);

    return self::$builder;
  }

  /**
   * Membuat sql transaction
   * 
   * @param callable $action
   * 
   * @return void
   */
  public static function beginTransaction(callable $action)
  {
    self::setBuilder();
    self::$builder->beginTransaction();

    try {
      $action();
      self::$builder->commit();
    } catch (\PDOException $e) {
      self::$builder->rollback();
      throw $e->getMessage();
    }
  }
}
