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

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
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
     * @param string $path
     */
    public function importProducts(string $path):void
    {
        $reader = new Reader();
        $products = $reader->getProducts($path);
        $this->createObjectProduct($products);

        foreach ($this->arrayProducts as $product) {
            $errors = $this->validator->validate($product);

            if (count($errors) === 0) {
                $this->successArray[] = $product;
                $this->entityManager->persist($product);
                $this->entityManager->flush();
            } else {
                $this->failsProducts[] = $product;
                $this->errorsArray[] = $errors;
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