<?php

namespace Fdm\Domain\Product\UseCase;

use Fdm\Domain\Product\Entity\ProductRepository;
use Fdm\Domain\Supplier\Entity\SupplierRepository;
use Fdm\Presentation\Product\ListProductsPresenter;
use Symfony\Component\HttpFoundation\Request;

class SearchProducts
{
    /**
     * @var SupplierRepository
     */
    protected $supplierRepository;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @param SupplierRepository $supplierRepository
     * @param ProductRepository  $productRepository
     */
    public function __construct(SupplierRepository $supplierRepository, ProductRepository $productRepository)
    {
        $this->supplierRepository = $supplierRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Request                 $request
     * @param ListProductsPresenter $presenter
     */
    public function execute(Request $request, ListProductsPresenter $presenter)
    {
        $listProductsResponse = new ListProductsResponse();

        $query = $request->query->get('query');
        $page = $this->computePage($request);

        if(empty($query) === false)
        {
            $products = $this->productRepository->searchProducts($query, $page);
            $totalProducts = $this->productRepository->countProducts($query);

            $listProductsResponse->setProducts($products);
            $listProductsResponse->setTotalProducts($totalProducts);
        }

        $presenter->present($listProductsResponse);
    }

    /**
     * @param Request $request
     * @return int
     */
    public function computePage(Request $request)
    {
        $page = $request->query->get('page');

        return ($page !== null) ? $page : 1;
    }
}