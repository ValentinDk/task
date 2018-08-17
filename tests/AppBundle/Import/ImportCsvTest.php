<?php

namespace Tests\AppBundle\Import;

use AppBundle\Import\ImportCsv;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\CsvReader\Reader;
use AppBundle\Entity\Product;

class ImportCsvTest extends KernelTestCase
{
    static $validator;
    static $entityManager;
    static $reader;
    static $container;

    private $importCsv;

    const PATH = 'tests/AppBundle/Resources/TestFilesCsv/test.csv';

    public static function setUpBeforeClass()
    {
        self::bootKernel();
        self::$container = self::$kernel->getContainer();
        self::$validator = self::$container->get('validator');
        self::$entityManager = self::$container->get('doctrine')->getManager();
        self::$reader = new Reader();
    }

    protected function setUp()
    {
        $this->importCsv = new ImportCsv(self::$entityManager, self::$validator, self::$reader);
    }

    protected function tearDown()
    {
        $this->importCsv = null;
    }

    public function testImportProduct()
    {
        $this->importCsv->importProducts(self::PATH, true);

        $this->assertAttributeCount(3, 'failsProducts', $this->importCsv);
        $this->assertAttributeCount(2, 'successProducts', $this->importCsv);
        $this->assertAttributeCount(5, 'arrayProducts', $this->importCsv);

        $this->assertEquals(3, $this->importCsv->getQuantityFails());
        $this->assertEquals(2, $this->importCsv->getQuantitySuccessful());
        $this->assertEquals(5, $this->importCsv->getTotalProducts());

        foreach ($this->importCsv->getFailsProducts() as $product) {
            $this->assertInstanceOf(Product::class, $product);
        }
    }
}
