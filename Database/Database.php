<?php

namespace Database;

use PDO;
use PDOException;
use PDOStatement;

class Database {
  private $charset = 'utf8mb4';
  public $pdo;
  private $dsn;

  public function __construct() {
      $this->connect();
  }

  /**
   * Establish the PDO database connection.
   *
   * @throws \RuntimeException if the connection fails
   */
  private function connect(): void {
    $host = $_ENV['MYSQL_HOST'] ?? false;
    $db = $_ENV['MYSQL_DB'] ?? false;
    $user = $_ENV['MYSQL_USER'] ?? false;
    $pass = $_ENV['MYSQL_PASS'] ?? false;
    
    if($host === false || $user === false || $pass === false || $db === false) {
      throw new \RuntimeException("Database connection parameters are not set in the environment variables.");
    }

    $this->dsn = "mysql:host={$host};dbname={$db};charset={$this->charset};sslmode=DISABLED";

    try {
      $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ];
      $this->pdo = new PDO($this->dsn, $user, $pass, $options);
    } catch (PDOException $e) {
      throw new \RuntimeException("Could not connect to the database. Please check your configuration.", 0, $e);
    }
  }

  /**
   * Get the PDO database connection instance.
   *
   * @return PDO
   * @throws \RuntimeException if the connection is not established
   */
  public function getPDO(): PDO {
    if($this->pdo === null) {
      // If connect() was called in __construct and failed, an exception would
      // have already been thrown. This check is mostly for robustness
      // if the class were used differently.
      throw new \RuntimeException("Database connection was not successfully established.");
    }
    return $this->pdo;
  }

  public function select(string $query): bool | PDOStatement {
    try {
      return $this->pdo->query($query);
    } catch (PDOException $e) {
      error_log("". $e->getMessage());
      throw new \RuntimeException("Error executing query: ".$query, 0, $e);
    }
  }
}