<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    /**
     * @var string
     */
    public const CURRENCY_CZK = 'czk';

    /**
     * @var string
     */
    public const CURRENCY_EUR = 'eur';
    /**
     * last payment day from DB
     *
     * @var string
     */
    public const LAST_DATETIME = '2021-10-25 00:00:00';

    public EntityManager $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(User $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAllUserTransactions(string $currency): ?array
    {
        $entityManager = $this->getEntityManager();

        $lastDatetime = date_create(self::LAST_DATETIME);
        $fromLast30days = date_sub($lastDatetime, date_interval_create_from_date_string('30 days'));

        $query = $entityManager->createQueryBuilder();
        return $query->select('u.name', 'SUM(t.price) as price')
            ->from('App\Entity\User', 'u')
            ->innerJoin('App\Entity\Transaction', 't', 'WITH', 't = u.user_id')
            ->where('t.currency = :currency')
            ->andWhere('t.created_at > :fromLastMonth')
            ->setParameter('fromLastMonth', $fromLast30days)
            ->setParameter('currency', $currency)
            ->groupBy('u.user_id')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);



        //$paginator = new Paginator($query);

        /*
        return $paginator
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);
        */

    }
}
