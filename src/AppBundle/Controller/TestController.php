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

        $this->importCsv->importProducts($path);

        $success = $this->importCsv->getQuantitySuccessful();
        $fails = $this->importCsv->getQuantityFails();
        $total = $this->importCsv->getTotalProducts();
        $failsProducts = $this->importCsv->getFailsProducts();

        return $this->render('/test/test.html.twig', ['total' => $total, 'success' => $success, 'fails' => $fails, 'failsProducts' => $failsProducts]);
    }
}
