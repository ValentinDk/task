<?php

namespace AppBundle\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Service\CSVParser;

class TestCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('test:test')
            ->addArgument('csv', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('csv');
        $parser = new CSVParser();
        $result = $parser->parser($path);
        $output->writeln($result);
    }
}