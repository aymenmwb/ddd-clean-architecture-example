<?php

namespace Fdm\Presentation\Product;

use Fdm\Domain\Product\Entity\Product;

class ProductsHtmlViewModel
{
    /**
     * @var int
     */
    public $total;

    /**
     * @var array
     */
    public $products;

    /**
     * @param Product $product
     *
     * @return self
     */
    public function add(Product $product): self
    {
        $this->products[] = array(
            'code' => $product->getProductCode(),
            'price' => $product->getProductPrice(),
            'supplier' => $product->getProductSupplier(),
            'description' => $product->getProductDescription()
        );

        return $this;
    }

    /**
     * @param int $total
     *
     * @return self
     */
    public function total(int $total): self
    {
        $this->total = $total;

        return $this;
    }
}