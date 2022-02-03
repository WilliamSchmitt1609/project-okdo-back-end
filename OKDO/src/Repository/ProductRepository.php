<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Product;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    
    // /**
    //  * @return Product[] Returns an array of Product objects
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

    /**
     * Liste des products par ordre alpha
     * en DQL
     */
    public function findAllOrderedByTitleAscDql()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Product p
            ORDER BY p.name ASC'
        );


        // returns an array of Movie objects
        return $query->getResult();
    }
    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
 /*    public function eventSearch($event)
    {

             $qb = $this->createQueryBuilder('p')  
            ->select('p', 'e')
            ->from('product', 'p') 
            ->from('event', 'e')
            ->leftJoin('event', 'e', Join::WITH, 'p.event = e.id')// event
            ->where('p.events = ?1')
            ->orderBy('p.name', 'ASC')
            ->setParameter(1, 5);
            // ->setParameter('event', $event);

        return $qb->getQuery()
                        ->getResult();
    } */

     /**
     * test des genres avec expr()
     */
   /*     Public function findProductGenreByfilters($label)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->innerJoin('App\Entity\Genre', 'g',  Join::WITH , 'g = p.genre')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->eq('p.genre','?1'),
                    $qb->expr()->like('g.label', '?2')
                )
            )
            
        ->setParameter('label', $label);

        dump($qb->getQuery()->getSQL());


    }   */

    /**
     * 
     */
    public function search($categorie = null){
   /*      $query = $this->createQueryBuilder('p');
        $query->where('p.status = 1');

        if($categorie != null){
            $query->leftJoin('p.categories', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $categorie);
        }
        return $query->getQuery()->getResult(); */
/* 
        $query = $this->createQueryBuilder('p')
        ->from('product')
        ->innerJoin()
        ->where(''); */
    }


}
