<?php

namespace AppBundle\Import;

use AppBundle\Entity\Product;
use Port\Csv\CsvReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportCsv
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @param CsvReader $reader
     * @return array
     */
    public function getArrayProducts(CsvReader $reader):array
    {
        $arrayProducts = [];

        foreach ($reader as $row) {
            $product = new Product();
            $product->createFromArray($row);
            $arrayProducts[] = $product;
        }

        return $arrayProducts;
    }

    public function importProducts($arrayProducts)
    {
        $errorsArray = [];
        $failsArray = [];
        $totalSuccess = 0;
        $totalFails = 0;
        foreach ($arrayProducts as $product) {
            $errors = $this->validator->validate($product);

            if (count($errors) === 0) {
                $totalSuccess++;
                $this->entityManager->persist($product);
                $this->entityManager->flush();
            } else {
                $totalFails++;
                $failsArray[] = $product;
                $errorsArray[] = $errors;
            }
        }
    }
}