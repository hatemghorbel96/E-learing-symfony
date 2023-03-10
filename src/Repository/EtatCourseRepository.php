<?php

namespace App\Repository;

use App\Entity\EtatCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtatCourse>
 *
 * @method EtatCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatCourse[]    findAll()
 * @method EtatCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatCourse::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(EtatCourse $entity, bool $flush = true): void
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
    public function remove(EtatCourse $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return EtatCourse[] Returns an array of EtatCourse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtatCourse
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

  

    public function test($user)
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.user = :val2')
                 
        ->setParameter('val2', $user)
        ->select('(p.course)')
        
           
            ->getQuery()
            ->getResult()
        ;
    }
}
