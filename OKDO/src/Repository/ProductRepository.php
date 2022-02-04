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



   /*  public function searchByCategories(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categoryLabel = $request->get('label');

    $query = $repository->createQueryBuilder('')


    }  */


    /**
     * 
     */
    /*   Public function findProductGenreByfilters()
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->innerJoin('App\Entity\Genre', 'g',  Join::WITH , 'g = p.genre')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->isNotNull('p.genre'),
                    $qb->expr()->like('g.label', ':label')
                )
            )

        ->setParameter('label', $label);

        dump($qb->getQuery()->getSQL());


    }   */


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
    }*/


                  //   MULTIPLE TESTS FOR ALGO SEARCH QB / DQL (not working)

        public function findProductByFilters(){


            return $this->createQueryBuilder('p')
            ->select('p.name, p.description, p.picture, p.shopping_link, p.ages_id')
            ->from('Repository:Agerepository','a')
            ->leftJoin('p.ages', 'a')
            ->where('a.id  AND ')
            ->setParameter('start', )

        }

    }

/* SELECT *
FROM
 product p
INNER JOIN age_product ap ON p.id = ap.product_id
INNER JOIN event_product ep ON p.id = ep.product_id
INNER JOIN product_category pc ON p.id = pc.product_id
WHERE 
ap.age_id IN (1,2,3,4)
AND
 ep.event_id IN (1,2,3,4,5)
AND 
pc.category_id IN (1,2,3,4,5,6,7)
AND 
p.genre_id IN (1,2,3)
GROUP BY p.id /*

