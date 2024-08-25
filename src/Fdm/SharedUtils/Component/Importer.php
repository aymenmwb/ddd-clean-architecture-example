<?php

namespace Fdm\SharedUtils\Component;

class Importer
{
    protected static $imports = array(
        'product' => array(
            'title' => 'Products',
            'extraFields' => array('supplier')
        )
    );

    protected $columnSeparator;

    protected $extraFields;

    protected $data, $objects;

    protected $total = 0;

    /**
     *
     * @return array
     */
    public static function getImports(): array
    {
        return self::$imports;
    }

    /**
     * @param string $columnSeparator
     */
    public function setColumnSeparator(string $columnSeparator): void
    {
        $this->columnSeparator = (string)$columnSeparator;
    }

    public function setExtraFields(array $extraFields): void
    {
        $this->extraFields = $extraFields;
    }

    /**
     * @param string $filePath
     */
    public function setDataFromFile(string $filePath): void
    {
        $this->data =  $this->getArrayFromFile($filePath);

        $this->sanitizeData();

        $this->executeImport();
    }

    /**
     * @return void
     */
    public function sanitizeData(){}

    /**
     * @return void
     */
    public function executeImport(){}

    /**
     * @param string $filePath
     *
     * @return array
     *
     * @throws \Exception
     */
    private function getArrayFromFile(string $filePath): array
    {
        return $this->getArrayFromCsvFile($filePath);
    }

    /**
     * @param string $filePath
     *
     * @return array
     */
    private function getArrayFromCsvFile($filePath): array
    {
        $handle = fopen($filePath, 'r');

        if ($handle == true):
            $firstRow = fgetcsv($handle, 0, $this->columnSeparator);
            rewind($handle);

            if (empty($firstRow) == true):
                throw new \Exception('Empty file (' . basename($filePath) . ')');
            endif;
        else:
            throw new \Exception('Invalid file (' . basename($filePath) . ')');
        endif;

        $fileContent = fread($handle, 8192);
        $fileIsUtf8 = $this->getStringIsUtf8($fileContent);
        rewind($handle);

        $array = array();

        $i = 0;
        while (($row = fgetcsv($handle, 0, $this->columnSeparator)) !== false):
            $array[$i] = $row;

            if ($fileIsUtf8 == false):
                foreach ($array[$i] as $k => $v):
                    if ($v != ''):
                        $array[$i][$k] = utf8_encode($v);
                    endif;
                endforeach;
            endif;

            if ($i > 40000):
                throw new \Exception('Too many rows (max. 40000)');
            endif;

            $i++;
        endwhile;

        fclose($handle);

        return $array;
    }

    function getStringIsUtf8($s): bool
    {
        return (bool)(@iconv('utf-8', 'utf-8//IGNORE', $s) == $s);
    }

    public function getLogs()
    {
        return $this->data['logs'];
    }

}