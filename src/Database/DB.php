<?php

namespace Src\Database;

use Src\Database\QueryBuilder;

/**
 * Database DB class
 */
class DB
{
  /**
   * Set properti builder dengan class QueryBuilder
   * 
   * @return QueryBuilder
   */
  protected static function builder(): QueryBuilder
  {
    return new QueryBuilder();
  }

  /**
   * Set tabel database
   * 
   * @param string $table
   * 
   * @return QueryBuilder
   */
  public static function table(string $name): QueryBuilder
  {
    $builder = self::builder();
    $builder->table($name);

    return $builder;
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
    $builder = self::builder();
    $builder->beginTransaction();

    try {
      $action();
      $builder->commit();
    } catch (\PDOException $e) {
      $builder->rollback();
      throw $e->getMessage();
    }
  }
}
