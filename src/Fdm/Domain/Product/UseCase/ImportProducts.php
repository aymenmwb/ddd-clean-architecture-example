<?php

namespace Fdm\Domain\Product\UseCase;

use Fdm\Domain\Product\Entity\ProductRepository;
use Fdm\Domain\Product\Model\CatalogueProduct;
use Fdm\Domain\Supplier\Entity\Supplier;
use Fdm\Domain\Supplier\Entity\SupplierRepository;
use Fdm\Presentation\Product\ImportProductsPresenter;
use Fdm\SharedUtils\Component\ProductImporter;
use Symfony\Component\HttpFoundation\Request;

class ImportProducts
{
    private $importer;

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
    public function __construct(ProductImporter $importer, SupplierRepository $supplierRepository, ProductRepository $productRepository)
    {
        $this->importer = $importer;
        $this->supplierRepository = $supplierRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param ImportProductsRequest|null  $request
     * @param ImportProductsPresenter     $presenter
     */
    public function execute(?ImportProductsRequest $request, ImportProductsPresenter $presenter)
    {
        $importProductsResponse = new ImportProductsResponse();

        $suppliers = $this->supplierRepository->getAll();
        $importProductsResponse->setSuppliers($suppliers);

        if (is_null($request) === false) {
            $supplierId = $request->supplierId;

            /** @var Supplier $supplier */
            $supplier = $this->supplierRepository->findOne($supplierId);

            if(!is_null($supplier)){
                $extraFieldsToImport = array('supplierId' => $supplier->getSupplierId());

                $this->import($request, $extraFieldsToImport);

                $countProductsImport = $this->importer->getLogs()['totalImported'];

                $importProductsResponse->setCountImported($countProductsImport);
                $importProductsResponse->setSupplierImport($supplier->getSupplierName());
            }
        }

        $presenter->present($importProductsResponse);
    }

    /**
     * @param ImportProductsRequest $request
     * @param array  $extraFields
     * @param string $import
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function import(ImportProductsRequest $request, array $extraFields , string $import = 'product'): array
    {
        $imports = ProductImporter::getImports();

        if(!isset($imports[$import])){
            throw new \Exception('Import Not found');
        }
        $this->importer->setColumnSeparator(',');
        $this->importer->setExtraFields($extraFields);

        $this->importer->setDataFromFile($request->filePathName);

        return $this->importer->getLogs();
    }
}