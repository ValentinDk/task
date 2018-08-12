<?php

namespace AppBundle\Commands;

use AppBundle\Import\ImportCsv;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    const TOTAL = "Total processed: %d";
    const SUCCESS = "Successfully: %d";
    const FAILS = "Unsuccessfully: %d";

    private $importCsv;

    public function __construct(ImportCsv $importCsv)
    {
        $this->importCsv = $importCsv;

        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->setName('test:test')
            ->addArgument('csv', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('csv');
        $this->importCsv->importProducts($path);

        $success = $this->importCsv->getQuantitySuccessful();
        $fails = $this->importCsv->getQuantityFails();
        $total = $this->importCsv->getTotalProducts();
        $failsProducts = $this->importCsv->getFailsProducts();

        $output->writeln(sprintf(self::TOTAL, $total));
        $output->writeln(sprintf(self::SUCCESS, $success));
        $output->writeln(sprintf(self::FAILS, $fails));
        $output->writeln($failsProducts);
    }
}