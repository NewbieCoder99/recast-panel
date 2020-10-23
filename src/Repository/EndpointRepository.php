<?php

namespace App\Repository;

use App\Entity\Endpoint;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Endpoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Endpoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Endpoint[]    findAll()
 * @method Endpoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EndpointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Endpoint::class);
    }

    /**
     * @param User $user
     * @param int $streamId
     * @return array
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getEndpoints(User $user, int $streamId) : array
    {
        $qb = $this->createQueryBuilder('endpoint')
            ->leftJoin('endpoint.stream', 'stream')
            ->where('stream.userId = :userId')
            ->andWhere('stream.id = :id')
            ->setParameter('userId', $user->getId())
            ->setParameter('id', $streamId)
            ->getQuery();

        return $qb->getResult(Query::HYDRATE_ARRAY);
    }
}
