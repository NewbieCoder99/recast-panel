<?php


namespace App\Controller;

use App\Component\ServiceManager;
use Doctrine\DBAL\Connection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Dashboard
 * @Route("/api")
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Dashboard extends Controller
{
    /**
     * @Route(path="/stats")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param Connection $connection
     * @param ServiceManager $manager
     * @return JsonResponse
     * @throws \Doctrine\DBAL\DBALException
     */
    public function index(Connection $connection, ServiceManager $manager)
    {
        $data = [];
        $data['streams'] = $connection->fetchColumn('SELECT COUNT(*) FROM streams');
        $data['liveStreams'] = $connection->fetchColumn('SELECT COUNT(*) FROM streams WHERE live = 1');
        $data['users'] = $connection->fetchColumn('SELECT COUNT(*) FROM `user`');
        $data['endpoints'] = \count($manager->getTemplateData());

        return new JsonResponse($data);
    }
}