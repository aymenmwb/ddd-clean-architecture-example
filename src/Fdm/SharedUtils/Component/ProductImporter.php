<?php

namespace Fdm\SharedUtils\Component;


use Fdm\Domain\Product\Entity\ProductRepository;
use Fdm\Domain\Product\Model\CatalogueProduct;

class ProductImporter extends Importer
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     *
     */
    public function sanitizeData(): void
    {
        foreach ($this->data as $k => $row) {
            $code = $row[1];
            $description = $row[0];
            $price = (float)$row[2];
            $supplierId = $this->extraFields['supplierId'];
            $object = new CatalogueProduct($code, $description, $price, $supplierId);
            $valid = $this->validateData($object);
            if ($valid === true) {
                $this->objects[] = $object;
            }

            unset($this->data[$k]);
        }
    }

    /**
     * @param CatalogueProduct $object
     *
     * @return bool
     */
    public function validateData(CatalogueProduct $object): bool
    {
        $valid = true;

        if ($object->getPrice() > 1000 || $object->getPrice() < 0) {
            $this->data['logs'][] = 'Product price ' . $object->getCode() . ' is not valid';
            $valid = false;
        }

        if (strlen($object->getCode()) > 6) {
            $this->data['logs'][] = 'Product code ' . $object->getCode() . ' is not valid';
            $valid = false;
        }

        return $valid;
    }

    public function executeImport(): void
    {

        foreach ($this->objects as $object)
        {
            $import = $this->productRepository->addToCatalogue($object);
            if($import === true)
                $this->total++;
        }

        $this->data['logs']['totalImported'] = $this->total;

    }
}