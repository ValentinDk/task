<?php

namespace AppBundle\Controller;

use AppBundle\Import\ImportCsv;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\CsvReader\Reader;


class TestController extends Controller
{
    private $importCsv;

    public function __construct(ImportCsv $importCsv)
    {
        $this->importCsv = $importCsv;
    }

    public function indexAction()
    {
        $path = 'D:\XAMPP\htdocs\testSymfony\test\app\Resources\filesCSV\stock.csv';

        $reader = new Reader();
        $products = $reader->getProducts($path);
        $import = $this->importCsv;

        $arrayProducts = $import->getArrayProducts($products);

        $import->importProducts($arrayProducts);

        return $this->render('/test/test.html.twig');
    }
}