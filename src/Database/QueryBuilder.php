<?php

namespace Src\Database;

use PDO;
use PDOException;

/**
 * Database QueryBuilder class
 */
class QueryBuilder
{
  /**
   * Definisi database
   * 
   * @var string
   */
  private string $host, $name, $user, $pass;

  /**
   * Nama tabel
   * 
   * @var string
   */
  protected string $table;

  /**
   * Database handler
   * 
   * @var PDO
   */
  protected PDO $dbh;

  /**
   * Query statment
   * 
   * @var object
   */
  protected object $stmt;

  /**
   * Struktur query language
   * 
   * @var string
   */
  protected string $sql;

  /**
   * Value untuk binding data
   * 
   * @var array
   */
  protected array $bindValue = [];

  /**
   * Set properti & jalankan koneksi database
   */
  public function __construct()
  {
    $this->host = config('database.host');
    $this->name = config('database.name');
    $this->user = config('database.user');
    $this->pass = config('database.password');

    // Data source name & oprions
    $dns = "mysql:host={$this->host};dbname={$this->name}";
    $options = [
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ];

    try {
      $this->dbh = new PDO($dns, $this->user, $this->pass, $options);
    } catch (PDOException $e) {
      throw new PDOException($e->getMessage());
    }
  }

  /**
   * Set value for binding
   * 
   * @param string $key
   * @param string|int|bool|null $value
   * 
   * @return void
   */
  public function setBindValue(string $key, string|int|bool|null $value): void
  {
    $this->bindValue[$key] = $value;
  }

  /**
   * Binding value
   * 
   * @return void
   */
  public function bind(): void
  {
    if (count($this->bindValue) > 0) {
      foreach ($this->bindValue as $key => $value) {
        switch ($value) {
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;

          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;

          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;

          default:
            $type = PDO::PARAM_STR;
        }

        $this->stmt->bindValue($key, trim($value), $type);
      }
    }
  }

  /**
   * Eksekusi query
   * 
   * @return int
   */
  public function run(): int
  {
    $sql = trim($this->sql);

    $this->stmt = $this->dbh->prepare($sql);
    $this->bind();
    $this->stmt->execute();

    return $this->stmt->rowCount();
  }

  /**
   * Set properti table
   * 
   * @param string $table
   * 
   * @return object
   */
  public function table(string $table): object
  {
    $this->table = $table;

    return $this;
  }

  /**
   * Query select
   * 
   * @param string|array $column
   * 
   * @return QueryBuilder
   */
  public function select(string|array $columns = ['*']): QueryBuilder
  {
    $columns = is_array($columns) ? $columns : func_get_args();
    $columns = implode(', ', $columns);

    $this->sql = "SELECT {$columns} FROM {$this->table} ";

    return $this;
  }

  /**
   * Query where
   * 
   * @param  string $column
   * @param  string $operator
   * @param  string|int $value
   * 
   * @return QueryBuilder
   */
  public function where(string $column, string $operator, string|int $value): QueryBuilder
  {
    $this->sql .= "WHERE {$column} {$operator} :{$column} ";
    $this->setBindValue($column, $value);

    return $this;
  }

  /**
   * Query and where
   * 
   * @param  string $column
   * @param  string $operator
   * @param  int $value
   * 
   * @return QueryBuilder
   */
  public function andWhere(string $column, string $operator, string|int $value): QueryBuilder
  {
    $this->sql .= "AND {$column} {$operator} :{$column} ";
    $this->setBindValue($column, $value);

    return $this;
  }

  /**
   * Query or where
   * 
   * @param  string $column
   * @param  string $operator
   * @param  int $value
   * 
   * @return QueryBuilder
   */
  public function orWhere(string $column, string $operator, string|int $value): QueryBuilder
  {
    $this->sql .= "OR {$column} {$operator} :{$column} ";
    $this->setBindValue($column, $value);

    return $this;
  }

  /**
   * Query not where
   * 
   * @param  string $column
   * @param  string $operator
   * @param  int $value
   * 
   * @return QueryBuilder
   */
  public function notWhere(string $column, string $operator, string|int $value): QueryBuilder
  {
    $this->sql .= "NOT {$column} {$operator} :{$column} ";
    $this->setBindValue($column, $value);

    return $this;
  }

  /**
   * Query where full text search
   * 
   * @param array|string $columns
   * @param string $value
   * 
   * @return QueryBuilder
   */
  public function whereFullText(array|string $columns, string $value): QueryBuilder
  {
    $columns = is_array($columns) ? implode(', ', $columns) : $columns;
    $columns = htmlspecialchars(trim($columns));

    $this->sql .= "WHERE MATCH({$columns}) AGAINST(:value IN NATURAL LANGUAGE MODE) ";
    $this->setBindValue('value', $value);

    return $this;
  }

  /**
   * Query limit
   * 
   * @param  int $number
   * 
   * @return QueryBuilder
   */
  public function limit(int $number): QueryBuilder
  {
    $this->sql .= "LIMIT {$number} ";
    return $this;
  }

  /**
   * Query offset
   * 
   * @param  int $number
   * 
   * @return QueryBuilder
   */
  public function offset(int $number): QueryBuilder
  {
    $this->sql .= "OFFSET {$number} ";
    return $this;
  }

  /**
   * Query order by
   * 
   * @param string $column
   * @param string $sort
   * 
   * @return QueryBuilder
   */
  public function orderBy(string $column, string $sort = 'ASC'): QueryBuilder
  {
    $sort = strtoupper($sort);
    $this->sql .= "ORDER BY {$column} {$sort} ";

    return $this;
  }

  /**
   * Jalankan query & kembalikan semua hasil data yang didapat
   * 
   * @return array
   */
  public function get()
  {
    $this->run();
    return $this->stmt->fetchAll();
  }

  /**
   * Jalankan query & kembalikan 1 hasil data yang didapat
   * 
   * @return array
   */
  public function first()
  {
    $this->run();
    return $this->stmt->fetch();
  }

  /**
   * Query insert 1 row
   * 
   * @param array $params
   * 
   * @return QueryBuilder
   */
  public function insert(array $data): QueryBuilder
  {
    $columns = implode(', ', array_keys($data));
    $values = ':' . implode(', :', array_keys($data));

    $this->sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";

    foreach ($data as $key => $value) {
      $this->setBindValue($key, $value);
    }

    return $this;
  }

  /**
   * Query delete
   * 
   * @param string $column
   * 
   * @return QueryBuilder
   */
  public function delete(): QueryBuilder
  {
    $this->sql = "DELETE FROM {$this->table} ";
    return $this;
  }

  /**
   * Query update
   * 
   * @param array $data
   * 
   * @return QueryBuilder
   */
  public function update(array $data): QueryBuilder
  {

    $values = '';

    foreach ($data as $key => $value) {
      if (array_key_last($data) === $key) {
        $values .= "{$key}=:{$key}";
      } else {
        $values .= "{$key}=:{$key}, ";
      }

      $this->setBindValue($key, $value);
    }

    $this->sql = "UPDATE {$this->table} SET {$values} ";

    return $this;
  }

  /**
   * Query for update
   * 
   * @return QueryBuilder
   */
  public function forUpdate(): QueryBuilder
  {
    $this->sql .= "FOR UPDATE ";

    return $this;
  }
}
