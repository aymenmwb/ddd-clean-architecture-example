<?php

namespace Fdm\Presentation\Product;


use Fdm\Domain\Product\UseCase\ListProductsResponse;

class ListProductsPresenter
{
    private $viewModel;

    /**
     * @param ListProductsResponse $response
     */
    public function present($response): void
    {
        $this->viewModel = new ProductsHtmlViewModel();
        foreach ($response->getProducts() as $row) {
            $this->viewModel->add($row);
        }

        $this->viewModel->total($response->getTotalProducts());
    }

    public function viewModel(): ProductsHtmlViewModel
    {
        return $this->viewModel;
    }
}