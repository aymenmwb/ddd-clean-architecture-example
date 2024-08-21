<?php

namespace Fdm\Presentation\Product;


class ListProductsPresenter
{
    private $viewModel;

    /**
     * @param array $response
     */
    public function present($response): void
    {
        $this->viewModel = new ProductsHtmlViewModel();
        foreach ($response as $row) {
            $this->viewModel->add($row);
        }

        $this->viewModel->total();
    }

    public function viewModel(): ProductsHtmlViewModel
    {
        return $this->viewModel;
    }
}