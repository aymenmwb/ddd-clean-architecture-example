<?php

namespace Fdm\Domain\Product\UseCase;

class ImportProductsResponse
{
    /**
     * @var int
     */
    private $countImported;

    /**
     * @var
     */
    private $supplierImport;

    /**
     * @var array
     */
    private $suppliers;

    /**
     * @return int|null
     */
    public function getCountImported(): ?int
    {
        return $this->countImported;
    }

    /**
     * @param int $countImported
     */
    public function setCountImported(int $countImported): void
    {
        $this->countImported = $countImported;
    }

    /**
     * @return mixed
     */
    public function getSupplierImport()
    {
        return $this->supplierImport;
    }

    /**
     * @param mixed $supplierImport
     */
    public function setSupplierImport($supplierImport): void
    {
        $this->supplierImport = $supplierImport;
    }

    /**
     * @return array
     */
    public function getSuppliers(): array
    {
        return $this->suppliers;
    }

    /**
     * @param array $suppliers
     */
    public function setSuppliers(array $suppliers): void
    {
        $this->suppliers = $suppliers;
    }

}