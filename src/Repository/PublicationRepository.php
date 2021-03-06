<?php

namespace App\Repository;

use App\Entity\Publication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }

    // /**
    //  * @return Publication[] Returns an array of Publication objects
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
    public function findOneBySomeField($value): ?Publication
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    //en DQL
    public function findbestpublication()
    {
        $entityManager = $this->getEntityManager();
        $dql = " 
                SELECT p 
                FROM App\Entity\Publication p 
                WHERE p.dateCreated > 2021/01/01
                ORDER BY p.dateCreated DESC       
 ";
        $query =$entityManager->createQuery($dql);
        $query->setMaxResults(30);
        $resulats = $query->getResult();

        dump($resulats);
        return $resulats;
    }


    // QuieryBuilder
   /* public function findbestpublication(){
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder->andWhere('p.date_format()>2022/01/01');
        $queryBuilder->addOrderBy('p.dateCreated' ,'DESC');

        $query = $queryBuilder->getQuery();

        $query->setMaxResults(50);
        $results = $query->getResult();
        return $results;
    }
   */

    }
