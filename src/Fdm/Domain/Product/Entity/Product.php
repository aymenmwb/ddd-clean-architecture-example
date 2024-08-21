<?php

namespace Fdm\Domain\Product\Entity;

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

    public function __construct($code, $price)
    {
        $this->productCode = $code;
        $this->productPrice = $price;
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
}