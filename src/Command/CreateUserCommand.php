<?php


namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreateUserCommand
 * @author Soner Sayakci <shyim@posteo.de>
 */
class CreateUserCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * CreateUserCommand constructor.
     * @param null|string $name
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(?string $name = null, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($name);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function configure()
    {
        $this
            ->setName('recast:create:user')
            ->setDescription('Creates a new user');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('What should be the username?');

        do {
            $email = $io->ask('What should be the email?');
            $valid = (bool) filter_var($email, FILTER_VALIDATE_EMAIL);

            if (!$valid) {
                $io->error('Invalid email address');
            }

        } while(!$valid);

        $password = $io->askHidden('What should be the password?');

        $user = new User();
        $encoded = $this->passwordEncoder->encodePassword($user, $password);
        $user->setUsername($username);
        $user->setPassword($encoded);
        $user->setEmail($email);

        $manager = $this->container->get('doctrine.orm.default_entity_manager');
        $manager->persist($user);
        $manager->flush();

        $io->success('User has been successfully created');
    }
}