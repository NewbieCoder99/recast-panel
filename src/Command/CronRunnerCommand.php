<?php

namespace App\Command;

use App\Component\Nginx\ConfigGenerator;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class CronRunnerCommand
 * @author Soner Sayakci <shyim@posteo.de>
 */
class CronRunnerCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var ConfigGenerator
     */
    private $configGenerator;

    /**
     * CronRunnerCommand constructor.
     * @param null|string $name
     * @param Connection $connection
     * @param ConfigGenerator $configGenerator
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(?string $name = null, Connection $connection, ConfigGenerator $configGenerator)
    {
        parent::__construct($name);
        $this->connection = $connection;
        $this->configGenerator = $configGenerator;
    }

    /**
     * @author Soner Sayakci <shyim@posteo.de>
     */
    protected function configure()
    {
        $this
            ->setName('recast:cron')
            ->setDescription('Reloads RTMP Server if needed');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @author Soner Sayakci <shyim@posteo.de>
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->connection->fetchColumn('SELECT 1 FROM queue')) {
            $this->configGenerator->generate();
            system($this->container->getParameter('nginxReloadCommand'));

            $io = new SymfonyStyle($input, $output);
            $io->success('Configs generated, rtmp has been reloaded');
            $this->connection->executeQuery('TRUNCATE queue');
        }
    }
}