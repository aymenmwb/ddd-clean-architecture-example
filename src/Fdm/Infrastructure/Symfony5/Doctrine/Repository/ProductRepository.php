<?php

namespace Symfony5\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fdm\Domain\Product\Entity\Product;
use Fdm\Domain\Product\Entity\ProductRepository as PRepository;
use Fdm\Domain\Product\Model\CatalogueProduct;
use Symfony5\Doctrine\Entity\Product as ProductEntity;
use Symfony5\Doctrine\Entity\Supplier;

class ProductRepository extends ServiceEntityRepository implements PRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductEntity::class);
    }

    /**
     * @param int $page
     * @param int $maxResults
     *
     * @return Product[]
     */
    public function getAll($page, $maxResults = 30)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('product')
            ->from(ProductEntity::class, 'product')
            ->setMaxResults($maxResults)
            ->setFirstResult(($maxResults * $page) - $maxResults);

        $productsEntities = $qb->getQuery()->getResult();

        $convertToObject = function (ProductEntity $product) {
            return (new Product($product->getCode(), $product->getPrice(), $product->getDescription(), $product->getSupplier()));
        };

        return array_map($convertToObject, $productsEntities);
    }

    /**
     * @param CatalogueProduct $catalogueProduct
     */
    public function addToCatalogue(CatalogueProduct $catalogueProduct)
    {

        $productEntity = new ProductEntity();
        $productEntity->setCode($catalogueProduct->getCode());
        $productEntity->setDescription($catalogueProduct->getDescription());
        $productEntity->setPrice($catalogueProduct->getPrice());
        $supplierForeign = $this->getEntityManager()->getReference(Supplier::class, $catalogueProduct->getSupplierProductId());

        $productEntity->setSupplier($supplierForeign);
        $this->getEntityManager()->persist($productEntity);
        $this->getEntityManager()->flush();

        return true;
    }

    /**
     * @param string $query
     * @param int    $page
     * @param int    $maxResults
     *
     * @return Product[]
     */
    public function searchProducts(string $query, $page, $maxResults = 30)
    {
        $params = array(
            ':query' => '%' . $query . '%'
        );

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('product')
            ->from(ProductEntity::class, 'product')
            ->where('product.code like :query')
            ->orWhere('product.description like :query')
            ->setMaxResults($maxResults)
            ->setFirstResult(($maxResults * $page) - $maxResults)
            ->setParameters($params);

        $productsEntities = $qb->getQuery()->getResult();

        $convertToObject = function (ProductEntity $product) {
            return (new Product($product->getCode(), $product->getPrice(), $product->getDescription(), $product->getSupplier()));
        };

        return array_map($convertToObject, $productsEntities);
    }

    /**
     * @param string|null $query
     *
     * @return int
     */
    public function countProducts(string $query = null)
    {
        if(is_null($query) === false)
        {
            $params = array(
                ':query' => '%' . $query . '%'
            );
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(product.id) as count')
            ->from(ProductEntity::class, 'product');
        if(empty($query) === false)
        {
            $qb->where('product.code like :query')
            ->orWhere('product.description like :query')
            ->setParameters($params);
        }

        return $qb->getQuery()->getSingleScalarResult();
    }

}