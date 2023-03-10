<?php

namespace App\Repository;

use App\classe\Search;
use App\Entity\Course;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Course $entity, bool $flush = true): void
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
    public function remove(Course $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Course[] Returns an array of Course objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Course
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

      /**
     * requette for search product par category
    * @return Course[] Returns an array of Produit objects
    */   
    public function findWithSearch(Search $search){

        $query = $this
          ->createQueryBuilder('p')
          ->Select('c','p')
          ->join('p.technology','c');
  
          if(!empty($search->technologies)){
              $query =$query
              ->andWhere('c.id IN (:technologies)')
              ->setParameter('technologies', $search->technologies);
          }
         
  
          if(!empty($search->string)){
              $query =$query
              ->andWhere('p.nom LIKE :string')
              ->setParameter('string', "%{$search->string}%");
          } 
          return $query->getQuery()->getResult();
         
      }

  
      public function gg($user)
    {
        return $this->createQueryBuilder('c')
        ->join('c.Progresses', 'p') 
        ->andWhere('p.user = :val2')->setParameter('val2', $user) 
                  
         
        
        ->Select('DISTINCT(p.course)')        
            ->getQuery()
            ->getResult()
        ;
    }

    // afficher le cours ili en progression 3adni
    public function list_course_progress($user)
    {
        $em = $this->getEntityManager();
        $req = $em->createQuery(
            'SELECT c FROM App\Entity\Course c JOIN c.Progresses AS p WHERE p.user=:val2')->setParameter('val2',$user);


        return $req->getResult();
    }


    public function videos($user)
    {
        return $this->createQueryBuilder('c')
        ->join('c.Progresses', 'p') 
        ->andWhere('p.user = :val2')->setParameter('val2', $user) 
        ->GroupBy('p.course')     
         
        
        ->Select('(p.course)')        
            ->getQuery()
            ->getResult()
        ;
    }


      public function findTopFollows()
    {
        return $this->createQueryBuilder('c')
           
         
        ->innerJoin('c.follows', 'follows')
        ->addSelect('SIZE(c.follows),c')   
        
            ->getQuery()
            ->getResult()
        ;
    }  
    

   /*    public function findTopFollows()
    {
        $em = $this->getEntityManager();
        $req = $em->createQuery(
        'SELECT u FROM user_course u'
        );
        
        return $req->getResult();
        }   */

        public function toprating()
        {
            return $this->createQueryBuilder('c')
            ->addSelect('c') 
            ->innerjoin('c.comments', 'com') 
            /* ->andWhere('com.rating = :val')->setParameter('val', 5)  */  
            ->GroupBy('com.course') 
            ->orderBy('SUM(com.rating)/COUNT(com.rating)', 'DESC')
           
            
            ->setMaxResults(6)
                
                ->getQuery()
                ->getResult()
            ;
        }


        

}
