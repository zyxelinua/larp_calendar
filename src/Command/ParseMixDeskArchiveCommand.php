<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ArchiveMixDeskParser;

class ParseMixDeskArchiveCommand extends Command
{
    private $parser;

    public function __construct(ArchiveMixDeskParser $parser, $name = null)
    {
        parent::__construct($name);
        $this->parser = $parser;
    }


    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:parse-archive-mix-desk')

            // the short description shown while running "php bin/console list"
            ->setDescription('Parses archive data mix-desk properties')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to parse file with archive of events mix-desk properties')
            ->addArgument('filename', InputArgument::REQUIRED, 'name of file to parse')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        $this->parser->parseFile($output, $filename);
    }
}
