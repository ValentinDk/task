<?php

namespace AppBundle\Import;

use AppBundle\Entity\Product;
use Port\Csv\CsvReader;
use AppBundle\CsvReader\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportCsv
{
    private $entityManager;
    private $validator;
    private $successArray = [];
    private $failsProducts = [];
    private $arrayProducts = [];
    private $errorsArray = [];
    private $reader;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, Reader $reader)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->reader = $reader;
    }

    /**
     * @param CsvReader $products
     */
    private function createObjectProduct(CsvReader $products):void
    {
        foreach ($products as $row) {
            $product = new Product();
            $product->createFromArray($row);
            $this->arrayProducts[] = $product;
        }
    }

    /**
     * @param Product $product
     */
    private function saveProduct(Product $product):void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    /**
     * @return bool
     */
    private function isValid(Product $product):bool
    {
        $errors = $this->validator->validate($product);

        if (count($errors) === 0) {
            $this->successArray[] = $product;
            return true;
        } else {
            $this->failsProducts[] = $product;
            $this->errorsArray[] = $errors;
            return false;
        }
    }

    /**
     * @param string $path
     */
    public function importProducts(string $path, bool $test):void
    {
        $products = $this->reader->getProducts($path);
        $this->createObjectProduct($products);

        foreach ($this->arrayProducts as $product) {
            if ($this->isValid($product) && !$test) {
                $this->saveProduct($product);
            }
        }
    }

    /**
     * @return int
     */
    public function getQuantitySuccessful()
    {
        return count($this->successArray);
    }

    /**
     * @return int
     */
    public function getQuantityFails()
    {
        return count($this->failsProducts);
    }

    /**
     * @return int
     */
    public function getTotalProducts()
    {
        return count($this->arrayProducts);
    }

    /**
     * @return array
     */
    public function getFailsProducts()
    {
        return $this->failsProducts;
    }
}