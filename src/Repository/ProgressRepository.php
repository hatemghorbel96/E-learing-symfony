<?php

namespace App\Repository;

use App\Entity\Progress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Progress>
 *
 * @method Progress|null find($id, $lockMode = null, $lockVersion = null)
 * @method Progress|null findOneBy(array $criteria, array $orderBy = null)
 * @method Progress[]    findAll()
 * @method Progress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Progress::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Progress $entity, bool $flush = true): void
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
    public function remove(Progress $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Progress[] Returns an array of Progress objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Progress
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findetat($id)
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.video = :val')
            
        ->setParameter('val', $id)
        
        ->select('p.etat')
       
            
            
            ->getQuery()
            ->getResult()
        ;
    }


    public function counte($user,$course)
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.course = :val AND p.user = :val2')
            
        ->setParameter('val', $course)
        ->setParameter('val2', $user)
        
       
       
            
            
            ->getQuery()
            ->getResult()
        ;
    }

    // nb course for user
    public function nbcourseprog($user)
    {
        return $this->createQueryBuilder('p')
        ->Select('DISTINCT(p.course),(c)')  
        ->andWhere('p.user = :val2')->setParameter('val2', $user) 
                ->Leftjoin('p.course', 'c')   
         
        
                   
            ->getQuery()
            ->getResult()
        ;
    }


   

    public function videos($user)
    {
        $em = $this->getEntityManager();
        $req = $em->createQuery(
            'SELECT p FROM App\Entity\Progress p WHERE p.user=:val2 ')->setParameter('val2',$user);


        return $req->getResult();
    }


   
}
