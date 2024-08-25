<?php

namespace Fdm\SharedUtils\Helper;

class Directory
{
    /**
     * @param string $file
     *
     * @return string
     */
    public static function getFileExtension($file)
    {
        $pos = strpos($file, '.');

        if ($pos !== false):
            $extension = substr($file, $pos + 1);
        else:
            $extension = '';
        endif;

        return $extension;
    }
}
