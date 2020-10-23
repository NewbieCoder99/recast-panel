<?php


namespace App\Command;


use App\Component\Nginx\ConfigGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GenerateConfigCommand
 * @author Soner Sayakci <shyim@posteo.de>
 */
class GenerateConfigCommand extends Command
{
    /**
     * @var ConfigGenerator
     */
    private $configGenerator;

    /**
     * GenerateConfigCommand constructor.
     * @param null|string $name
     * @param ConfigGenerator $configGenerator
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(?string $name = null, ConfigGenerator $configGenerator)
    {
        parent::__construct($name);
        $this->configGenerator = $configGenerator;
    }

    /**
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function configure()
    {
        $this
            ->setName('recast:generate')
            ->setDescription('Regenerates rtmp config');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->configGenerator->generate();
        $io = new SymfonyStyle($input, $output);

        $io->success('Configs generated');
    }
}
