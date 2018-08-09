<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Port\Csv\CsvReader;
use Port\Doctrine\DoctrineWriter;
use Port\Steps\StepAggregator as Workflow;

class TestController extends Controller
{
    public function indexAction()
    {
        $path = 'D:\XAMPP\htdocs\testSymfony\test\app\Resources\filesCSV\stock.csv';

        $file = new \SplFileObject($path);
        $reader = new CsvReader($file);
        $reader->setHeaderRowNumber(0);

        $nameColumn = ['productCode', 'productName', 'productDescription', 'stock', 'costInUSA', 'discontinued'];
        $reader->setColumnHeaders($nameColumn);

        $entityManager = $this->getDoctrine()->getManager();
        $writer = new DoctrineWriter($entityManager, 'AppBundle:Product');

        $workflow = new Workflow($reader);
        $workflow->addWriter($writer);
        $workflow->process();

        $errors = $reader->getErrors();

        foreach ($errors as $error) {

            echo "<pre>";
            echo "Incorrect data for the product:";
            echo "</pre>";

            foreach ($error as $key => $val) {
                echo "$val ";
            }
        }

        return $this->render('/test/test.html.twig', ['result' => $reader, 'errors' => $val]);
    }
}