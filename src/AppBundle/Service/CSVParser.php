<?php

namespace AppBundle\Service;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CSVParser
{
    public function parser($path)
    {
        $serializer = new Serializer([new ObjectNormalizer(), new ArrayDenormalizer()], [new CsvEncoder()]);

        $products = $serializer->deserialize(file_get_contents($path), 'AppBundle\Entity\Product[]', 'csv');

        return $products;
    }
}