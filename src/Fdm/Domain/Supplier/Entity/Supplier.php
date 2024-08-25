<?php

namespace Fdm\Domain\Supplier\Entity;

class Supplier
{
    /**
     * @var int
     */
    private $supplierId;

    /**
     * @var string
     */
    private $supplierName;

    public function __construct($id, $name)
    {
        $this->supplierId = $id;
        $this->supplierName = $name;
    }

    /**
     * @return int
     */
    public function getSupplierId(): int
    {
        return $this->supplierId;
    }

    /**
     * @return string
     */
    public function getSupplierName(): string
    {
        return $this->supplierName;
    }
}