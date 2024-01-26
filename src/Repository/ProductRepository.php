<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
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

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

      public function exists(string $value): array
      {
        $result = $this->createQueryBuilder("product")
         ->andWhere("product.Sku = :value")
         ->setParameter("value", $value)
         ->getQuery()
         ->getScalarResult();
         return $result;
      }

   public function findOneBySku($value): ?Product
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.Sku = :value')
           ->setParameter('value', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
