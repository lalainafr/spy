<?php

namespace App\Repository;

use App\Data\Search;
use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{

    /**
     * @var PaginatorInterface
     */

    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Mission::class);
        $this->paginator = $paginator;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Mission $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Mission $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    /**
     * Récupére les missions en lien avec la recherche
     * @return Mission[] 
     */

    public function findSearch(Search $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('m')
            ->select('t', 'm')
            ->join('m.type', 't')

            ->select('c', 'm')
            ->join('m.country', 'c');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('m.title LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->country)) { {
                $query = $query
                    ->andWhere('c.id IN (:country)')
                    ->setParameter('country', $search->country);
            }
        }

        if (!empty($search->type)) { {
                $query = $query
                    ->andWhere('t.id IN (:type)')
                    ->setParameter('type', $search->type);
            }
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            3
        );
    }


    /*
    public function findOneBySomeField($value): ?Mission
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
