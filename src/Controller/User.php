<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api/auth")
 * Class User
 * @author Soner Sayakci <shyim@posteo.de>
 */
class User extends Controller
{
    /**
     * @Route(path="/user")
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function me()
    {
        return new JsonResponse($this->getUser());
    }

    /**
     * @Route(path="/refresh")
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function refresh()
    {
        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route(path="/changePassword")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param Request $request
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $userPasswordEncoder) : JsonResponse
    {
        $currentPassword = $request->request->get('currentPassword');
        $newPassword = $request->request->get('newPassword');
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (!$userPasswordEncoder->isPasswordValid($user, $currentPassword)) {
            return new JsonResponse(['message' => 'Current password does not match'], 500);
        }

        $encodedPassword = $userPasswordEncoder->encodePassword($user, $newPassword);

        $user->setPassword($encodedPassword);

        $manager = $this->get('doctrine.orm.default_entity_manager');
        $manager->persist($user);
        $manager->flush();

        return new JsonResponse();
    }
}