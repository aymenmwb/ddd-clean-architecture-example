<?php

namespace Symfony\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fdm\Domain\Product\Entity\Product;
use Fdm\Domain\Product\Entity\ProductRepository as PRepository;
use Symfony\Doctrine\Entity\Product as ProductEntity;

class ProductRepository extends ServiceEntityRepository implements PRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductEntity::class);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('product')
            ->from(ProductEntity::class, 'product');

        $productsEntities = $qb->getQuery()->getResult();

        $convertToObject = function (ProductEntity $product) {
            return (new Product($product->getCode(), $product->getPrice()));
        };

        return array_map($convertToObject, $productsEntities);
    }

}