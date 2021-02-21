<?php

namespace App\Command;

namespace App\Command;

use App\Services\ImportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportFileCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'import:file';

    protected function configure()
    {
        $this->setDescription('Export file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importService = new ImportService();

        $importService->importFile();

        return Command::SUCCESS;
    }
}