<?php

namespace Fdm\Domain\Product\UseCase;

use Fdm\Domain\Product\Entity\ProductRepository;
use Fdm\Presentation\Product\ListProductsPresenter;
use Fdm\SharedUtils\Pagination;

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
     * @param $request
     * @param ListProductsPresenter $presenter
     */
    public function execute($request, ListProductsPresenter $presenter)
    {
        $listProductsResponse = new ListProductsResponse();

        $page = Pagination::computeCurrentPage($request);

        $products = $this->productRepository->getAll($page);
        $totalProducts = $this->productRepository->countProducts();

        $listProductsResponse->setProducts($products);
        $listProductsResponse->setTotalProducts($totalProducts);

        $presenter->present($listProductsResponse);
    }
}