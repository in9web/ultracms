<?php
namespace Ultra\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ServerCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('server')
            // Don\'t use this in a production environment
            ->setDescription('PHP Built-in Server for '.ULTRANAME)
            ->addOption(
               'h',
               null,
               InputOption::VALUE_NONE,
               'Default host localhost'
            )
            ->addOption(
               'p',
               null,
               InputOption::VALUE_NONE,
               'Default port 8000'
            )
            ->addOption(
               'd',
               null,
               InputOption::VALUE_NONE,
               'Default document root .'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host           = 'localhost';
        $port           = 8000;
        $document_root  = BASEPATH;
        
        if ($input->getOption('h')) {
            $host = $input->getOption('h');
        }

        if ($input->getOption('p')) {
            $port = $input->getOption('p');
        }

        if ($input->getOption('d')) {
            $document_root = $input->getOption('d');
        }

        chdir($document_root);

        $command = sprintf(
            "php -S %s:%d -t %s",
            $host,
            $port,
            $document_root// . '/index.php'
        );

        $port = ':'.$port;

        $output->writeln(sprintf('built-in server is running in http://%s%s/', $host, $port));
        $output->writeln('<error>[WARN] Don\'t use this in a production environment</error>');
        $output->writeln('<info>[COMMAND] '.$command.'</info>');
        $output->writeln(sprintf('You can exit with <info>`CTRL-C`</info>'));

        //system($command);
        passthru($command);
    }

}