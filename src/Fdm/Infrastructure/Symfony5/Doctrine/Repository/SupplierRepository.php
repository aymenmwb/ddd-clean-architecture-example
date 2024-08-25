<?php

namespace Symfony5\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fdm\Domain\Supplier\Entity\Supplier;
use Fdm\Domain\Supplier\Entity\SupplierRepository as baseSupplierRepository;
use Symfony5\Doctrine\Entity\Supplier as SupplierEntity;

class SupplierRepository extends ServiceEntityRepository implements baseSupplierRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupplierEntity::class);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('supplier')
            ->from(SupplierEntity::class, 'supplier');

        $suppliersEntities = $qb->getQuery()->getResult();

        $convertToObject = function (SupplierEntity $supplier) {
            return (new Supplier($supplier->getId(), $supplier->getName()));
        };

        return array_map($convertToObject, $suppliersEntities);
    }

    /**
     * @param int $id
     *
     * @return Supplier
     */
    public function findOne(int $id): Supplier
    {
        $supplier = null;
        $supplierEntity = $this->find(['id' => $id]);

        if ($supplierEntity)
            $supplier = new Supplier($supplierEntity->getId(), $supplierEntity->getName());

        return $supplier;
    }

}