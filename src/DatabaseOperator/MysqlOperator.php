<?php

namespace Sgiberne\DatabaseTools\DatabaseOperator;

final class MysqlOperator extends AbstractDatabaseOperator
{
    public function createDatabase(string $databaseName, bool $ifNotExists = true): void
    {
        $ifNotExistsCondition = $ifNotExists ? ' IF NOT EXISTS ' : '';
        try {
            $this->executeSql(sprintf("CREATE DATABASE $ifNotExistsCondition `%s`;", $databaseName));
        } catch (\PDOException $e) {
            throw new \RuntimeException("Cannot create database $databaseName. Error: ".$e->getMessage());
        }
    }

    public function useDatabase(string $databaseName): void
    {
        try {
            $this->executeSql(sprintf("USE `%s`;", $databaseName));
        } catch (\PDOException $e) {
            throw new \RuntimeException("Cannot use database $databaseName. Error: ".$e->getMessage());
        }
    }

    public function dropDatabase(string $databaseName, bool $ifExists = true): void
    {
        $ifExistsCondition = $ifExists ? ' IF EXISTS ' : '';
        try {
            $this->executeSql(sprintf("DROP DATABASE $ifExistsCondition `%s`;", $databaseName));
        } catch(\PDOException $e) {
            throw new \RuntimeException("Cannot drop database $databaseName. Error: ".$e->getMessage());
        }
    }

    public function executeSql(string $sql): void
    {
        if (!$this->connection) {
            throw new \RuntimeException('Connection not found');
        }

        if (empty($sql)) {
            var_dump($sql); die;
            throw new \RuntimeException('Cannot execute empty query');
        }

        $this->connection->exec($sql);
    }
}
