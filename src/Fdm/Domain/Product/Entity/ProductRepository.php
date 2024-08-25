<?php declare(strict_types=1);

namespace Fdm\Domain\Product\Entity;

use Fdm\Domain\Product\Model\CatalogueProduct;

interface ProductRepository
{
    public function getAll(int $page, int $maxResults = 30);
    public function addToCatalogue(CatalogueProduct $catalogueProduct);
    public function searchProducts(string $query, int $page, int $maxResults = 30);
    public function countProducts(string $query = null);

}