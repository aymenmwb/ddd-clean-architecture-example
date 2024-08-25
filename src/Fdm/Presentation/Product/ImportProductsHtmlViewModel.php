<?php

namespace Fdm\Presentation\Product;

use Fdm\Domain\Supplier\Entity\Supplier;

class ImportProductsHtmlViewModel
{
    /**
     * @var array
     */
    public $suppliers;

    /**
     * @var int
     */
    public $countProductsImported;

    /**
     * @var string
     */
    public $supplierImport;

    /**
     * @param Supplier $supplier
     *
     * @return self
     */
    public function add(Supplier $supplier): self
    {
        $this->suppliers[$supplier->getSupplierId()] = $supplier->getSupplierName();

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCountProductsImported(): ?int
    {
        return $this->countProductsImported;
    }

    /**
     * @param int $countProductsImported
     */
    public function setCountProductsImported(int $countProductsImported): void
    {
        $this->countProductsImported = $countProductsImported;
    }

    /**
     * @return string
     */
    public function getSupplierImport(): string
    {
        return $this->supplierImport;
    }

    /**
     * @param string $supplierImport
     */
    public function setSupplierImport(string $supplierImport): void
    {
        $this->supplierImport = $supplierImport;
    }
}