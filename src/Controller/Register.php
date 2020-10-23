<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 * Class Register
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Register extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * Register constructor.
     * @param UserRepository $repository
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->repository = $repository;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @Route(path="/register")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if (!$this->isRegistrationEnabled()) {
            return new JsonResponse(['message' => 'Registration is disabled'], 500);
        }

        $data = $request->request->all();

        if (empty($data['username']) || !$this->isValidString($data['username'])) {
            return new JsonResponse(['message' => 'Name is empty or contains illegal chars. Please use A-Z, a-z, 0-9, .-_'], 500);
        }

        if ($this->repository->findOneBy(['username' => $data['username']])) {
            return new JsonResponse(['message' => 'Username is already taken'], 500);
        }

        if ($this->repository->findOneBy(['email' => $data['email']])) {
            return new JsonResponse(['message' => 'Email is already taken'], 500);
        }


        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $data['password']));
        $user->setEmail($data['email']);

        $manager = $this->get('doctrine.orm.default_entity_manager');

        try {
            $manager->persist($user);
            $manager->flush();
        } catch (ORMException $e) {
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }

        return new JsonResponse();
    }

    /**
     * @return bool
     * @author Soner Sayakci <shyim@posteo.de>
     */
    private function isRegistrationEnabled(): bool
    {
        return XmlUtils::phpize($this->container->getParameter('registrationEnabled'));
    }

    /**
     * @param null|string $string
     * @return false|int
     * @author Soner Sayakci <shyim@posteo.de>
     */
    private function isValidString(?string $string)
    {
        return preg_match('/^[A-Z|a-z|0-9|.|\-|_]+$/m', $string);
    }
}
