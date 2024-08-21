<?php

namespace Fdm\Domain\Product\UseCase;

use Fdm\Domain\Product\Entity\ProductRepository;
use Fdm\Presentation\Product\ListProductsPresenter;

class ListProducts
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param ListProductsPresenter $presenter
     */
    public function execute(ListProductsPresenter $presenter)
    {
        $products = $this->productRepository->getAll();

        $presenter->present($products);
    }
}