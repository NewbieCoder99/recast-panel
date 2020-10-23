<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Index
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Index extends Controller
{
    /**
     * @Route(path="/", name="index")
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function index(): Response
    {
        return $this->render('index.twig');
    }

    /**
     * @Route(path="/api/settings")
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function settings(): JsonResponse
    {
        return new JsonResponse([
            'registrationEnabled' => XmlUtils::phpize($this->container->getParameter('registrationEnabled'))
        ]);
    }
}