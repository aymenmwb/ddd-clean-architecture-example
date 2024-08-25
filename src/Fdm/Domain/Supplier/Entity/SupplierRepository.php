<?php declare(strict_types=1);

namespace Fdm\Domain\Supplier\Entity;

interface SupplierRepository
{
    public function getAll();
    public function findOne(int $id);
}