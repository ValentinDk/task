<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Service\CSVParser;

class TestController extends Controller
{
    public function indexAction()
    {
        $path = 'D:\XAMPP\htdocs\testSymfony\test\app\Resources\filesCSV\stock.csv';

        $parser = new CSVParser();
        $products = $parser->parser($path);

        $validator = $this->get('validator');

        $errors = [];

        foreach ($products as $product) {
            $errors[] = $validator->validate($product);
        }

        for ($i = 0; $i < count($errors); $i++) {
            $errors[$i] = (string) $errors[$i];
        }

        return $this->render('/test/test.html.twig', ['result' => $products, 'errors' => $errors]);
    }
}