<?php

namespace Fdm\Presentation\Product;


use Fdm\Domain\Product\UseCase\ImportProductsResponse;

class ImportProductsPresenter
{
    private $viewModel;

    /**
     * @param ImportProductsResponse $response
     */
    public function present($response): void
    {
        $this->viewModel = new ImportProductsHtmlViewModel();

        foreach ($response->getSuppliers() as $row) {
            $this->viewModel->add($row);
        }

        if(!is_null($response->getCountImported())) {
            $this->viewModel->setCountProductsImported($response->getCountImported());
            $this->viewModel->setSupplierImport($response->getSupplierImport());
        }
    }

    public function viewModel(): ImportProductsHtmlViewModel
    {
        return $this->viewModel;
    }
}