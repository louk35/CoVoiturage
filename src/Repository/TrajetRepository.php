<?php

namespace App\Repository;


use App\Entity\Trajet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trajet>
 *
 * @method Trajet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trajet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trajet[]    findAll()
 * @method Trajet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Trajet $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    /**
     * @return Trajet[]
     */
    public function getTrajetssNonExpires()
    {
        $qb = $this->createQueryBuilder('s')
            ->where('s.date_expiration > :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('s.date_creation', 'DESC');
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Trajet $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Trajet[] Returns an array of Trajet objects
    //  */

    public function findByDate($lieuDepart, $lieuArrive, $dateDepart)
    {
        return $this->createQueryBuilder('covoiturage')
            ->andWhere('covoiturage.dateDepart >= :dateDepart')
            ->setParameter('dateDepart', $dateDepart)
            ->andWhere('covoiturage.lieuDepart = :lieuDepart')
            ->setParameter('lieuDepart', $lieuDepart)
            ->andWhere('covoiturage.lieuArrive = :lieuArrive')
            ->setParameter('lieuArrive', $lieuArrive)
            ->orderBy('covoiturage.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Trajet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
