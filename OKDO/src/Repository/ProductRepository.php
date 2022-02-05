<?php

namespace App\Repository;

use App\Entity\Age;
use App\Entity\Event;
use App\Entity\Product;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\ResultSetMapping;
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

    /**
     * @param array $categories
     * @param array $ages
     * @param array $genres
     * @param array $events
     */
    public function findProductByFilters(array $categories = [], array $ages = [], array $genres = [], array $events = [])
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.status = 1')
            ->groupBy('p.id');

        if (!empty($categories)) {
            $query->innerJoin('p.categories', 'c')
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $categories);
        }

        if (!empty($ages)) {
            $query->innerJoin('p.ages', 'a')
                ->andWhere('a.id IN (:ages)')
                ->setParameter('ages', $ages);
        }

        if (!empty($genres)) {
            $query->innerJoin('p.genre', 'g')
                ->andWhere('g.id IN (:genres)')
                ->setParameter('genres', $genres);
        }

        if (!empty($events)) {
            $query->innerJoin('p.events', 'e')
                ->andWhere('e.id IN (:events)')
                ->setParameter('events', $events);
        }

//dd($query->getQuery()->getSQL());
dd($query->getQuery()->getResult());
        return $query->getQuery()->getResult();
    }



   /*  public function searchByCategories(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categoryLabel = $request->get('label');

    $query = $repository->createQueryBuilder('')


    }  */

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


    /*  public function findProductByFiltersDql()
    {

        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('Product', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p','name','name');
        $rsm->addFieldResult('p', 'picture', 'picture');
        $rsm->addFieldResult('p', 'description', 'description');
        $rsm->addFieldResult('p', 'shopping_link', 'shopping_link');
        $rsm->addJoinedEntityResult('Category', 'c', 'p', 'category');
        $rsm->addFieldResult('c', 'category_id', 'id');
        $rsm->addFieldResult('c', 'label', 'label');
        $rsm->addFieldResult('c', 'value', 'value');

        $sql = 'SELECT `name`,`description`,`picture`,`shopping_link`
        FROM product p
        INNER JOIN age_product ap ON p.id = ap.product_id
        INNER JOIN event_product ep ON p.id = ep.product_id
        INNER JOIN product_category pc ON p.id = pc.product_id
        WHERE ap.age_id IN (1,2,3)
        AND ep.event_id IN (3,4)
        AND pc.category_id IN (3,4)
        AND p.genre_id IN (3)
        GROUP BY p.id';

        $query = $this->_em->createNamedNativeQuery($sql, $rsm);
        $query->setParameter(1, 'geek');
    } */
}

   