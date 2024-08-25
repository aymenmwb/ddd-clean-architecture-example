<?php
namespace Fdm\Domain\Product\UseCase;

use Fdm\Domain\Product\Entity\Product;

class ListProductsResponse
{
    /**
     * @var Product[]
     */
    private $products;

    /**
     * @var int
     */
    private $totalProducts;

    public function __construct()
    {
        $this->products = array();
        $this->totalProducts = 0;

    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     *
     * @return self
     */
    public function setProducts(array $products): self
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalProducts(): int
    {
        return $this->totalProducts;
    }

    /**
     * @param int $totalProducts
     *
     * @return self
     */
    public function setTotalProducts(int $totalProducts): self
    {
        $this->totalProducts = $totalProducts;

        return $this;
    }
}