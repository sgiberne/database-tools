<?php

require __DIR__.'/../vendor/autoload.php';

use Sgiberne\DatabaseTools\Command\CreateDatabaseCommand;
use Sgiberne\DatabaseTools\Command\DropDatabaseCommand;
use Sgiberne\DatabaseTools\Command\ExecuteSqlScriptCommand;
use Symfony\Component\Console\Application;
use Sgiberne\DatabaseTools\DatabaseOperator\MysqlOperator;


$mysqlOperator = new MysqlOperator();
$application = new Application();

$application->add(new CreateDatabaseCommand($mysqlOperator));
$application->add(new DropDatabaseCommand($mysqlOperator));
$application->add(new ExecuteSqlScriptCommand($mysqlOperator));

$application->run();
