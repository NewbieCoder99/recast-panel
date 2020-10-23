<?php

namespace App\Repository;

use App\Entity\Streams;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Streams|null find($id, $lockMode = null, $lockVersion = null)
 * @method Streams|null findOneBy(array $criteria, array $orderBy = null)
 * @method Streams[]    findAll()
 * @method Streams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreamsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Streams::class);
    }

    /**
     * @param User $user
     * @author Soner Sayakci <shyim@posteo.de>
     * @return array
     */
    public function getStreams(User $user) : array
    {
        $qb = $this->createQueryBuilder('streams')
            ->addSelect('endpoints')
            ->where('streams.userId = :userId')
            ->leftJoin('streams.endpoints', 'endpoints')
            ->setParameter('userId', $user->getId())
            ->getQuery();

        return $qb->getResult(Query::HYDRATE_ARRAY);
    }

    /**
     * @return Streams[]
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getActiveStreams(): array
    {
        $qb = $this->createQueryBuilder('streams')
            ->addSelect('endpoints')
            ->addSelect('user')
            ->leftJoin('streams.endpoints', 'endpoints')
            ->leftJoin('streams.user', 'user')
            ->andWhere('streams.active = true')
            ->andWhere('endpoints.active = true')
            ->getQuery();

        return $qb->getResult();
    }

    /**
     * @param string $streamName
     * @param string $userName
     * @param string $streamKey
     * @return Streams
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getStreamByNameAndUsername(string $streamName, string $userName, string $streamKey): ?Streams
    {
        $qb = $this->createQueryBuilder('streams')
            ->addSelect('user')
            ->innerJoin('streams.user', 'user')
            ->andWhere('streams.active = true')
            ->andWhere('streams.name = :streamName')
            ->andWhere('user.username = :userName')
            ->andWhere('streams.streamKey = :streamKey')
            ->setParameter('streamName', $streamName)
            ->setParameter('streamKey', $streamKey)
            ->setParameter('userName', $userName)
            ->getQuery();

        $qb->setMaxResults(1);
        return $qb->getResult()[0];
    }
}
