<?php

namespace Sgiberne\DatabaseTools\Command;

use Sgiberne\DatabaseTools\DatabaseOperator\MysqlOperator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DropDatabaseCommand extends Command
{
    protected static $defaultName = 'sgiberne:database:drop';

    private MysqlOperator $mysqlOperator;

    public function __construct(MysqlOperator $mysqlOperator, string $name = null)
    {
        $this->mysqlOperator = $mysqlOperator;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Drop a database.')
            ->addArgument('dsn', InputArgument::REQUIRED, 'Dsn')
            ->addArgument('user', InputArgument::REQUIRED, 'Mysql user name')
            ->addArgument('password', InputArgument::REQUIRED, 'Mysql user password')
            ->addArgument('databaseName', InputArgument::REQUIRED, 'Database name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dsn = $input->getArgument('dsn');
        $user = $input->getArgument('user');
        $password = $input->getArgument('password');
        $databaseName = $input->getArgument('databaseName');

        $this->mysqlOperator->connect($dsn, $user, $password);
        $this->mysqlOperator->dropDatabase($databaseName);
        $this->mysqlOperator->disconnect();

        $output->writeln("$databaseName dropped");
        return Command::SUCCESS;
    }
}
