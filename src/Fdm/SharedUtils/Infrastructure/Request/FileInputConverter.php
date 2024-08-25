<?php

namespace Fdm\SharedUtils\Infrastructure\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileInputConverter
{
    public static function convert(UploadedFile $uploadedFile)
    {
        return array(
            'name' => $uploadedFile->getClientOriginalName(),
            'pathName' => $uploadedFile->getPathname()
        );
    }
}