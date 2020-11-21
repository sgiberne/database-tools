<?php

namespace Sgiberne\DatabaseTools\DatabaseOperator;

final class MysqlOperator extends AbstractDatabaseOperator
{
    public function createDatabase(string $databaseName): void
    {
        try {
            $this->executeSql(sprintf("CREATE DATABASE `%s`;", $databaseName));
        } catch (\PDOException $e) {
            throw new \RuntimeException("Cannot create database $databaseName. Error: ".$e->getMessage());
        }

        $this->disconnect();
    }

    public function dropDatabase(string $databaseName): void
    {
        try {
            $this->executeSql(sprintf("DROP DATABASE `%s`;", $databaseName));
        } catch(\PDOException $e) {
            throw new \RuntimeException("Cannot drop database $databaseName. Error: ".$e->getMessage());
        }

        $this->disconnect();
    }

    public function executeSql(string $sql): void
    {
        if (!$this->connection) {
            throw new \RuntimeException('Connection not found');
        }

        $this->connection->exec($sql);
    }
}
