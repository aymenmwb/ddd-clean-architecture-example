<?php

namespace Fdm\Domain\Product\Entity;

use Fdm\Domain\Supplier\Entity\Supplier;

class Product
{
    /**
     * @var string;
     */
    private $productCode;

    /**
     * @var float;
     */
    private $productPrice;

    /**
     * @var string
     */
    private $productDescription;

    /**
     * @var Supplier
     */
    private $productSupplier;

    public function __construct($code, $price, $description, $supplier)
    {
        $this->productCode = $code;
        $this->productPrice = $price;
        $this->productDescription = $description;
        $this->productSupplier = new Supplier($supplier->getId(), $supplier->getName());
    }

    /**
     * @return string
     */
    public function getProductCode(): string
    {
        return $this->productCode;
    }

    /**
     * @return float
     */
    public function getProductPrice(): float
    {
        return $this->productPrice;
    }

    /**
     * @return Supplier
     */
    public function getProductSupplier(): Supplier
    {
        return $this->productSupplier;
    }

    /**
     * @return string
     */
    public function getProductDescription(): string
    {
        return $this->productDescription;
    }
}