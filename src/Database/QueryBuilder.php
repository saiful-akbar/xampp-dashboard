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
   * @var string|null
   */
  protected ?string $table;

  /**
   * Database handler
   * 
   * @var PDO|null
   */
  protected ?PDO $dbh;

  /**
   * Query statment
   * 
   * @var object|null
   */
  protected ?object $stmt;

  /**
   * Struktur query language
   * 
   * @var string|null
   */
  protected ?string $sql;

  /**
   * Value untuk binding data
   * 
   * @var array|null
   */
  private ?array $bindValue = null;

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
   * Start transaction
   * 
   * @return void
   */
  public function beginTransaction(): QueryBuilder
  {
    $this->dbh->beginTransaction();

    return $this;
  }

  /**
   * Commit sql transaction
   * 
   * @return void
   */
  public function commit(): QueryBuilder
  {
    $this->dbh->commit();

    return $this;
  }

  /**
   * Rollback sql transaction
   * 
   * @return void
   */
  public function rollback(): QueryBuilder
  {
    $this->dbh->rollback();

    return $this;
  }

  /**
   * Prepare query
   * 
   * @param string|null $query
   * 
   * @return void
   */
  private function query(?string $sql = null): QueryBuilder
  {
    if (!is_null($sql)) $this->sql = $sql;

    $this->stmt = $this->dbh->prepare($this->sql);

    return $this;
  }

  /**
   * Set value for binding
   * 
   * @param string $key
   * @param string $value
   * 
   * @return void
   */
  protected function setBindValue(string $key, string $value): void
  {
    $this->bindValue = [$key => $value];
  }

  /**
   * Binding value
   * 
   * @param array $params
   * @param int|null $type
   * 
   * @return QueryBuilder
   */
  public function bind(?array $params = null, ?int $type = null): QueryBuilder
  {
    if (is_null($params)) {
      $params = $this->bindValue;
    }

    foreach ($params as $key => $value) {
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

    return $this;
  }

  /**
   * Eksekusi query
   * 
   * @return int
   */
  public function execute(): int
  {
    $this->stmt->execute();

    return $this->stmt->rowCount();
  }

  /**
   * Query select
   * 
   * @param mixed $fields
   * 
   * @return QueryBuilder
   */
  public function select(mixed $columns = ['*']): QueryBuilder
  {
    $columns = is_array($columns) ? $columns : func_get_args();
    $columns = implode(", ", $columns);

    $this->sql = "SELECT {$columns} FROM {$this->table}";

    return $this;
  }

  /**
   * Query limit
   * 
   * @param int|string $number
   * 
   * @return QueryBuilder
   */
  public function limit(int|string $number): QueryBuilder
  {
    $this->sql .= " LIMIT {$number}";

    return $this;
  }

  /**
   * Query offset
   * 
   * @param int $number
   * 
   * @return QueryBuilder
   */
  public function offset(int $number): QueryBuilder
  {
    $this->sql .= " OFFSET {$number}";

    return $this;
  }

  /**
   * Query order atau sort
   * 
   * @param string $field
   * @param string $sort
   * 
   * @return QueryBuilder
   */
  public function orderBy(string $field, string $sort = 'ASC'): QueryBuilder
  {
    if (strtoupper($sort) == 'DESC') {
      $sort = 'DESC';
    }

    $this->sql .= " ORDER BY {$field} {$sort}";

    return $this;
  }

  /**
   * Mengambil 1 data dari hasil pertama query
   * 
   * @return bool|object
   */
  public function first(): bool|object
  {
    $this->limit(1);
    $this->query($this->sql);

    if (!is_null($this->bindValue) && is_array($this->bindValue)) {
      $this->bind($this->bindValue);
    }

    $this->execute();

    return $this->stmt->fetch();
  }

  /**
   * Mengambil semua data dari hasil query
   * 
   * @return array
   */
  public function get(): array
  {
    $this->query($this->sql);

    if (!is_null($this->bindValue) && is_array($this->bindValue)) {
      $this->bind($this->bindValue);
    }

    $this->execute();

    return $this->stmt->fetchAll();
  }

  /**
   * Query insert 1 row
   * 
   * @param array $params
   * 
   * @return int
   */
  public function insert(array $data): int
  {
    $columns = implode(', ', array_keys($data));
    $values = ':' . implode(', :', array_keys($data));

    $this->sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";

    $this->query($this->sql);
    $this->bind($data);

    return $this->execute();
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

    $this->sql .= " WHERE MATCH({$columns}) AGAINST(:value IN NATURAL LANGUAGE MODE)";
    $this->setBindValue('value', $value);

    return $this;
  }

  /**
   * Where query
   * 
   * @param string $column
   * @param string $operator
   * @param string $value
   * 
   * @return QueryBuilder
   */
  public function where(string $column, string $operator, string $value): QueryBuilder
  {
    $this->sql .= " WHERE {$column} {$operator} :{$column}";

    $this->setBindValue($column, $value);

    return $this;
  }

  /**
   * Or where query
   * 
   * @param string $column
   * @param string $operator
   * @param string $value
   * 
   * @return QueryBuilder
   */
  public function orWhere(string $column, string $operator, string $value): QueryBuilder
  {
    $this->sql .= " OR WHERE {$column} {$operator} :{$column}";

    $this->setBindValue($column, $value);

    return $this;
  }

  /**
   * And where query
   * 
   * @param string $column
   * @param string $operator
   * @param string $value
   * 
   * @return QueryBuilder
   */
  public function andWhere(string $column, string $operator, string $value): QueryBuilder
  {
    $this->sql .= " AND WHERE {$column} {$operator} :{$column}";

    $this->setBindValue($column, $value);

    return $this;
  }
}
