<?php

namespace Fdm\Presentation\Product;

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
     * @param string $code
     * @param string $description
     * @param float $price
     *
     * @return self
     */
    public function add($product): self
    {
        $this->products[] = array(
            'code' => $product->getProductCode(),
            'price' => $product->getProductPrice()
        );

        return $this;
    }

    /**
     * @return int
     */
    public function total()
    {
        return $this->total = count($this->products);
    }
}