<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $product;

    protected function setUp()
    {
        $this->product = new Product();
    }

    /**
     * @dataProvider getProvider
     */
    public function testGetDiscontinued($value, $expect)
    {
        $this->product->setDiscontinued($value);
        $this->assertEquals($expect, $this->product->getDiscontinued());
    }

    public function getProvider()
    {
        return [
            ['yes', date(Product::FORMAT)],
            ['', null],
        ];
    }

    /**
     * @dataProvider setProvider
     */
    public function testSetDiscontinued($value, $expect)
    {
        $this->product->setDiscontinued($value);
        $this->assertAttributeInternalType($expect, 'discontinued', $this->product);
    }

    public function setProvider()
    {
        return [
            ['yes', 'object'],
            ['null', 'null'],
            ['', 'null'],
        ];
    }

    public function testCreateFromArray()
    {
        $data = [
            'productCode' => 'testCode',
            'productName' => 'testName',
            'productDescription' => 'testDescription',
            'stock' => '124',
            'costInUSA' => '51.32',
            'discontinued' => '',
        ];
        $this->product->createFromArray($data);
        $this->assertAttributeEquals('testCode', 'productCode', $this->product);
        $this->assertAttributeEquals('testName', 'productName', $this->product);
        $this->assertAttributeEquals('testDescription', 'productDescription', $this->product);
        $this->assertAttributeEquals('124', 'stock', $this->product);
        $this->assertAttributeEquals('51.32', 'costInUSA', $this->product);
        $this->assertAttributeEquals(null, 'discontinued', $this->product);
        $this->assertAttributeInternalType('float', 'costInUSA', $this->product);
        $this->assertAttributeInternalType('int', 'stock', $this->product);
    }
}