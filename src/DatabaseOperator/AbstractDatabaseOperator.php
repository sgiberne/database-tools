<?php

namespace Sgiberne\DatabaseTools\DatabaseOperator;

abstract class AbstractDatabaseOperator
{
    protected ?\PDO $connection = null;

    public function connect(string $dsn, string $user, string $password): \PDO
    {
        if ($this->connection !== null) {
            return $this->connection;
        }

        try {
            $this->connection = new \PDO($dsn, $user, $password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $this->connection;
        } catch (\PDOException $e) {
            throw new \RuntimeException(sprintf('Cannot connect to %s with user "%s" and password "%s". Error: %s', $dsn, $user, $password, $e->getMessage()));
        }
    }

    public function disconnect(): void
    {
        $this->connection = null;
    }

    abstract public function createDatabase(string $databaseName): void;
    abstract public function dropDatabase(string $databaseName): void;
    abstract public function executeSql(string $sql): void;

}
