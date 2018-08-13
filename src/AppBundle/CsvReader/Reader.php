<?php

namespace AppBundle\CsvReader;

use Port\Csv\CsvReader;

class Reader
{
    const COLUMN = ['productCode', 'productName', 'productDescription', 'stock', 'costInUSA', 'discontinued'];

    /**
     * @param string $path
     * @return CsvReader
     */
    public function getProducts(string $path):CsvReader
    {
        $file = new \SplFileObject($path);
        $reader = new CsvReader($file);

        $reader->setStrict(false);
        $reader->setHeaderRowNumber(0);
        $reader->setColumnHeaders(self::COLUMN);

        return $reader;
    }
}