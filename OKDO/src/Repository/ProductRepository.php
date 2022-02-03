<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

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
    }


      /**
     * 
     */
    public function search($category = null){
        $query = $this->createQueryBuilder('p');
        $query->where('p.status = 1');

        if($category != null){
            $query->leftJoin('p.category', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $category);
        }
        return $query->getQuery()->getResult();
    }
}
