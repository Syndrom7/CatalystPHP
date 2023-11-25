<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException, PDOStatement;

class Database {

    public PDO $connection;
    private PDOStatement $stmt;

    /**
     * Constructs a new Database instance.
     *
     * @param string $driver The database driver (e.g., mysql, pgsql).
     * @param array $config The database connection configuration.
     * @param string $username The database username.
     * @param string $password The database password.
     */
    public function __construct (string $driver, array $config, string $username, string $password) { 
        $config = http_build_query(data: $config, arg_separator: ";");
        $dsn = "{$driver}:{$config}";

        try {
            $this->connection = new PDO($dsn, $username, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        } catch (PDOException $exception) {
            die("Unable to connect to database");
        }
    }

    /**
     * Prepares and executes a SQL statement.
     *
     * @param string $query The SQL query to execute.
     * @param array $params The parameters to bind to the query.
     * @return Database Returns itself for method chaining.
     */
    public function query (string $query, array $params = []) : Database {
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->execute($params);
        return $this;
    }

    /**
     * Returns the number of rows affected by the SQL statement.
     *
     * @return int The number of rows.
     */
    public function count () : int {
        return $this->stmt->fetchColumn();
    }

    /**
     * Fetches a single row from the executed statement.
     *
     * @return mixed The fetched row as an associative array.
     */
    public function find (): mixed {
        return $this->stmt->fetch();
    }

    /**
     * Retrieves the ID of the last inserted row.
     *
     * @return string The last inserted row's ID.
     */
    public function id () : string {
        return $this->connection->lastInsertId();
    }

    /**
     * Fetches all rows from the executed statement.
     *
     * @return array An array of rows as associative arrays.
     */
    public function findAll () : array {
        return $this->stmt->fetchAll();
    }
}
