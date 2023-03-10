<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $entity, bool $flush = true): void
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
    public function remove(User $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    

    public function finduserprog($user,$course,$video)
    {
        return $this->createQueryBuilder('u')
        ->leftJoin('u.progresses', 'p')
        ->andWhere('p.course = :val AND p.user = :val2 and p.video = :val3')
            
        ->setParameter('val', $course)
        ->setParameter('val2', $user)
        ->setParameter('val3', $video)
        
        ->select('p.etat')
       
                   
            ->getQuery()
            ->getResult()
        ;
    }

    public function nbcourseprog($u)
    {
        return $this->createQueryBuilder('u')
        ->Join('u.progresses', 'p')
        ->andWhere('p.user = :val2')
            
     
        ->setParameter('val2', $u)
        ->Select('COUNT(DISTINCT p.course)')
                   
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function countcomplate($user)
    {
        return $this->createQueryBuilder('u')
        ->leftJoin('u.progresses', 'p')
        ->andWhere('p.user = :val AND p.etat = :val2')
            
        ->setParameter('val', $user)
        ->setParameter('val2', 1)
     
        
       
       
                   
            ->getQuery()
            ->getResult()
        ;
    }



}
