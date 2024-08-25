<?php

namespace Fdm\Domain\Product\UseCase;

class ImportProductsRequest
{
    /**
     * @var int
     */
    public $supplierId;

    /**
     * @var string
     */
    public $fileName;

    /**
     * @var string
     */
    public $filePathName;

    public static function fromPost(array $requestInputs)
    {
        $request = new self();
        $request->supplierId = $requestInputs['supplier'];
        $request->filePathName = $requestInputs['pathName'];
        $request->fileName = $requestInputs['name'];

        return $request;
    }

}