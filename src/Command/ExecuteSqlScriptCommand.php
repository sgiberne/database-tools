<?php

namespace Sgiberne\DatabaseTools\Command;

use Sgiberne\DatabaseTools\DatabaseOperator\MysqlOperator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecuteSqlScriptCommand extends Command
{
    protected static $defaultName = 'sgiberne:database:sql';

    private MysqlOperator $mysqlOperator;

    public function __construct(MysqlOperator $mysqlOperator, string $name = null)
    {
        $this->mysqlOperator = $mysqlOperator;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Execute a SQL script file.')
            ->addArgument('dsn', InputArgument::REQUIRED, 'Dsn')
            ->addArgument('user', InputArgument::REQUIRED, 'Mysql user name')
            ->addArgument('password', InputArgument::REQUIRED, 'Mysql user password')
            ->addArgument('file', InputArgument::REQUIRED, 'SQL script file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dsn = $input->getArgument('dsn');
        $user = $input->getArgument('user');
        $password = $input->getArgument('password');
        $file = $input->getArgument('file');

        if (!file_exists($file)) {
            throw new \RuntimeException("File $file doesn't exist");
        }

        if (!is_readable($file)) {
            throw new \RuntimeException("File $file isn't readable");
        }

        $sql = file_get_contents($file);

        $output->writeln('Will execute this sql');
        $output->writeln($sql);

        $this->mysqlOperator->connect($dsn, $user, $password);
        $this->mysqlOperator->executeSql($sql);
        $this->mysqlOperator->disconnect();

        $output->writeln('Done');
        return Command::SUCCESS;
    }
}
