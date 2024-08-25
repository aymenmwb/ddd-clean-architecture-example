<?php

namespace Fdm\Domain\Product\Model;

class CatalogueProduct
{
    /**
     * @var string;
     */
    private $code;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $price;

    /**
     * @var int
     */
    private $supplierProductId;

    public function __construct(
        $code,
        $description,
        $price,
        $supplierId
    ){
        $this->code = $code;
        $this->description = $description;
        $this->price = $price;
        $this->supplierProductId = $supplierId;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getSupplierProductId(): int
    {
        return $this->supplierProductId;
    }
}