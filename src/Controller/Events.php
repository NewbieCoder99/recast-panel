<?php

namespace App\Controller;

use App\Entity\Streams;
use App\Repository\StreamsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Events
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Events extends Controller
{
    /**
     * @var StreamsRepository
     */
    private $repository;

    /**
     * Events constructor.
     * @param StreamsRepository $repository
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(StreamsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/events/onPublish")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param Request $request
     * @return Response
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onPublish(Request $request): Response
    {
        $postData = $request->request->all();

        if (!$this->isRtmpCall($postData)) {
            return new Response();
        }

        if ($stream = $this->getStreamByRequest($postData)) {
            $stream->setLive(true);
            $manager = $this->get('doctrine.orm.default_entity_manager');
            $manager->persist($stream);
            $manager->flush();

            return new RedirectResponse('live');
        }

        return new Response('', 401);
    }

    /**
     * @Route("/events/onDone")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param Request $request
     * @return Response
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onDone(Request $request): Response
    {
        $postData = $request->request->all();

        if (!$this->isRtmpCall($postData)) {
            return new Response();
        }

        if ($stream = $this->getStreamByRequest($postData)) {
            $stream->setLive(false);
            $manager = $this->get('doctrine.orm.default_entity_manager');
            $manager->persist($stream);
            $manager->flush();
        }

        return new Response();
    }

    /**
     * @param array $data
     * @return bool
     * @author Soner Sayakci <shyim@posteo.de>
     */
    private function isRtmpCall(array $data): bool
    {
        return isset($data['app'], $data['flashver'], $data['addr'], $data['name']);
    }

    /**
     * @param array $data
     * @author Soner Sayakci <shyim@posteo.de>
     * @return Streams|null
     */
    private function getStreamByRequest(array $data): ?Streams
    {
        [$username, $streamName] = explode('/', $data['app']);
        $stream = $this->repository->getStreamByNameAndUsername($streamName, $username, $data['name']);

        return $stream;
    }
}
