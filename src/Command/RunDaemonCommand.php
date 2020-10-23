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

class RunDaemonCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    private $connection;
    private $configGenerator;

    public function __construct(?string $name = null, Connection $connection, ConfigGenerator $configGenerator)
    {
        parent::__construct($name);
        $this->connection = $connection;
        $this->configGenerator = $configGenerator;
    }

    protected function configure()
    {
        $this
            ->setName('recast:daemon')
            ->setDescription('Run daemon which automaticly update config and reloads RTMP Server if needed');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        while(1) {
            if ($this->connection->fetchColumn('SELECT 1 FROM queue')) {
                $this->configGenerator->generate();
                system($this->container->getParameter('nginxReloadCommand'));

                //$io = new SymfonyStyle($input, $output);
                //$io->success('Configs generated, rtmp has been reloaded');
                $this->connection->executeQuery('TRUNCATE queue');
            }
            sleep(3);
        }
    }
}
